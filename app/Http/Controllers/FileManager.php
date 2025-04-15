<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivityLog;
use App\Models\ProjectDetails; 
use App\Models\Project; 
use App\Http\Controllers\ActivityLogs;
use Barryvdh\DomPDF\Facade\Pdf;

class FileManager extends Controller 
{
    // Upload File
    public function uploadFile(Request $request, $project_id)
    {
        Log::info("Upload Request Received", $request->all());

        if (!$request->hasFile('file')) {
            Log::error("No file found in request.");
            return response()->json(['status' => 'error', 'message' => 'No file uploaded.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip'
        ]);

        if ($validator->fails()) {
            Log::error("Validation Failed", $validator->errors()->toArray());
            return response()->json(['status' => 'error', 'message' => 'Validation failed!', 'errors' => $validator->errors()], 422);
        }

        try {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();

            // Session data
            if (session()->has('loggedIn')) {
                $sessionData = session()->get('loggedIn');
                $username = $sessionData['performedBy'];
                $ofmis_id = $sessionData['ofmis_id'];
                $role = $sessionData['role'];
                $user_id = $sessionData['user_id'] ?? null;
            } else {
                Log::error("Session not found");
                return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
            }

            // Check for duplicate file
            $fileExists = ProjectFile::where('project_id', $project_id)
                ->where('fileName', $filename)
                ->exists();

            if ($fileExists) {
                Log::warning("Duplicate File Attempt: " . $filename);
                return response()->json(['status' => 'error', 'message' => 'File already exists'], 409);
            }

            $timestampedFilename = date('Ymd_His') . '_' . $filename;
            $filepath = $file->storeAs('project_files', $timestampedFilename, 'public');

            // Save record
            $projectFile = ProjectFile::create([
                'project_id' => $project_id,
                'fileName' => $timestampedFilename,
                'fileID' => uniqid(),
                'actionBy' => $username,
            ]);

            // Logging
            $action = "Uploaded file: $filename.";
            $request->session()->put('UploadedFile', [
                'user_id' => $user_id,
                'ofmis_id' => $ofmis_id,
                'performedBy' => $username,
                'role' => $role,
                'action' => $action,
            ]);

            (new ActivityLogs)->userAction($user_id, $ofmis_id, $username, $role, $action);

            Log::info("File uploaded successfully: " . $filename);
            return response()->json(['status' => 'success', 'message' => 'File uploaded successfully!', 'file' => $projectFile]);

        } catch (\Exception $e) {
            Log::error("Error uploading file: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error.', 'error_details' => $e->getMessage()], 500);
        }
    }

    // Get Files by Project ID
    public function getFiles($project_id)
    {
        $files = ProjectFile::where('project_id', $project_id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'files' => $files
        ]);
    }

    // Delete File
    public function delete($fileID)
    {
        $file = ProjectFile::where('fileID', $fileID)->first();

        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
        }

        Storage::delete('public/' . $file->file);
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
