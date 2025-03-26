<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileManager extends Controller {
    // ✅ Upload File
    public function uploadFile(Request $request) {
        try {
            \Log::info("Received project_id:", ['project_id' => $request->project_id]); // ✅ Debugging
    
            // ✅ Validate request
            $request->validate([
                'project_id' => 'required|exists:projects_tbl,id',
                'file' => 'required|file|max:10240' // 10MB max
            ]);
    
            // ✅ Read file content and encrypt it
            $file = $request->file('file');
            $encryptedContent = Crypt::encrypt(file_get_contents($file));
    
            // ✅ Store file in database
            $projectFile = ProjectFile::create([
                'projectID' => $request->project_id,
                'fileName' => $file->getClientOriginalName(),
                'fileID' => uniqid(),
                'file' => $encryptedContent, // ✅ Store encrypted file content
                'actionBy' => auth()->user()->name ?? 'Guest',
            ]);
    
            return response()->json(['status' => 'success', 'file' => $projectFile], 201);
    
        } catch (\Exception $e) {
            \Log::error("File upload error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function getFiles($projectID) {
        try {
            \Log::info("Fetching files for projectID: $projectID"); // ✅ Debugging
    
            // ✅ Ensure projectID exists in the projects table
            if (!\App\Models\ProjectFile::where('projectID', $projectID)->exists()) {
                \Log::error("Invalid project ID: $projectID");
                return response()->json(['status' => 'error', 'message' => 'Project does not exist'], 400);
            }
    
            // ✅ Fetch files for the project
            $files = \App\Models\ProjectFile::where('projectID', $projectID)->get();
    
            // ✅ Log output
            \Log::info("Files retrieved:", ['count' => $files->count(), 'data' => $files]);
    
            return response()->json([
                'status' => 'success',
                'files' => $files,
                'message' => $files->isEmpty() ? 'No files found for this project.' : 'Files retrieved successfully.'
            ]);
    
        } catch (\Exception $e) {
            \Log::error("Error fetching files: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function downloadFile($fileID) {
        try {
            $file = ProjectFile::findOrFail($fileID);
    
            // ✅ Decrypt the file content
            $decryptedContent = Crypt::decrypt($file->files);
    
            // ✅ Return file as a response for download
            return response($decryptedContent)
                ->header('Content-Type', mime_content_type($file->file_name))
                ->header('Content-Disposition', "attachment; filename=\"{$file->file_name}\"");
        } catch (\Exception $e) {
            \Log::error("Error downloading file: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'File not found or decryption failed.'], 404);
        }
    }
    
    

    // Delete File
    public function delete($fileID) {
        $file = ProjectFile::findOrFail($fileID);
        Storage::delete($file->file_path);
        $file->delete();
        
        return response()->json(['status' => 'success', 'message' => 'File deleted']);
    }
}
