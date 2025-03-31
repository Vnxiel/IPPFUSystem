<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class FileManager extends Controller {
    //  Upload File
    public function uploadFile(Request $request)
    {
        Log::info("Upload Request Received", $request->all());
    
        if (!$request->hasFile('file')) {
            Log::error("No file found in request.");
            return response()->json(['status' => 'error', 'message' => 'No file uploaded.'], 400);
        }
    
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
            $filename = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('project_files', $filename, 'public');
    
            Log::info("File stored at: " . $filepath);
            
            $projectFile = FileUpload::create([
                'projectID' => $request->input('projectID'),
                'fileName' => $filename,
                'fileID' => uniqid(),
                'file' => $filepath,
                'actionBy' => Session::get('username', 'Unknown'), // Retrieve username from session
            ]);
            
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

      Storage::delete('public/' . $file->file); // Delete from storage
      $file->delete(); // Delete from database

      return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
  }
}
