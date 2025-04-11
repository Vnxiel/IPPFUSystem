<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\ActLogs;
use App\Http\Controllers\ActivityLogs;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\showDetails; // Ensure you import the model

class FileManager extends Controller 
{
    // Upload File
    public function uploadFile(Request $request)
    {
        Log::info("Upload Request Received", $request->all());
    
        if (!$request->hasFile('file')) {
            Log::error("No file found in request.");
            return response()->json(['status' => 'error', 'message' => 'No file uploaded.'], 400);
        }
    
        // Removed username validation
        $validator = Validator::make($request->all(), [
            'projectID' => 'required|string|max:50',
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip'
        ]);
    
        if ($validator->fails()) {
            Log::error("Validation Failed", $validator->errors()->toArray());
            return response()->json(['status' => 'error', 'message' => 'Validation failed!', 'errors' => $validator->errors()], 422);
        }
    
        try {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $projectID = $request->input('projectID');
    
            // Get username from session
            if (session()->has('loggedIn')) {
                $sessionData = session()->get('loggedIn');
                $username = $sessionData['performedBy']; // Assuming this is the username
            } else {
                Log::error("Session not found");
                return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
            }
    
            Log::info("Checking if file exists: " . $filename);
            $fileExists = FileUpload::where('projectID', $projectID)
                ->where('fileName', $filename)
                ->exists();
    
            if ($fileExists) {
                Log::warning("Duplicate File Attempt: " . $filename);
                return response()->json(['status' => 'error', 'message' => 'File already exists'], 409);
            }
    
            $timestampedFilename = date('Ymd_His') . '_' . $filename;
            $filepath = $file->storeAs('project_files', $filename, 'public');
    
            Log::info("File stored at: " . $filepath);
    
            $projectFile = FileUpload::create([
                'projectID' => $projectID,
                'fileName' => $filename,
                'fileID' => uniqid(),
                'file' => $filepath,
                'actionBy' => $username, // Now assigning from session
            ]);
    
            // Logging user action
            $ofmis_id = $sessionData['ofmis_id'];
            $role = $sessionData['role'];
            $action = "Uploaded file: $filename.";
    
            $request->session()->put('UploadedFile', [
                'ofmis_id' => $ofmis_id,
                'performedBy' => $username,
                'role' => $role,
                'action' => $action,
            ]);
    
            Log::info("User action logged: " . json_encode($request->session()->get('UploadedFile')));
            (new ActivityLogs)->userAction($ofmis_id, $username, $role, $action);
    
            Log::info("File uploaded successfully: " . $filename);
            return response()->json(['status' => 'success', 'message' => 'File uploaded successfully!', 'file' => $projectFile]);
    
        } catch (\Exception $e) {
            Log::error("Error uploading file: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error.', 'error_details' => $e->getMessage()], 500);
        }
    }
  
    // Get Files by Project ID
    public function getFiles($projectID)
    {
        $files = FileUpload::where('projectID', $projectID)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'files' => $files
        ]);
    }

// Delete File
public function delete($fileID)
{
    $file = FileUpload::where('fileID', $fileID)->first();
    
    if (!$file) {
        return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
    }

    // Delete the file from the storage
    Storage::delete('public/' . $file->file); 

    // Delete from the database
    $file->delete();

    return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
}


public function downloadFile($filename)
{
    // Ensure the file exists in the storage
    $filePath = storage_path('app/public/project_files/' . $filename);
    
    if (!file_exists($filePath)) {
        return response()->json(['status' => 'error', 'message' => 'File not found or inaccessible.'], 404);
    }
    
    // Return the file as a download response
    return response()->download($filePath);
}


}

