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

    private function getUploadPath()
{
    $setting = \App\Models\UploadSetting::latest()->first();
    return $setting ? rtrim($setting->upload_path, DIRECTORY_SEPARATOR) : null;
}

public function uploadFile(Request $request, $project_id)
{
    Log::info("Upload Request Received", $request->all());

    if (!$request->hasFile('files')) {
        return response()->json(['status' => 'error', 'message' => 'No files uploaded.'], 400);
    }

    $files = $request->file('files');
    if (!is_array($files)) {
        $files = [$files];
    }

    $uploaded = [];
    $errors = [];

    if (!session()->has('loggedIn')) {
        return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
    }

    $sessionData = session()->get('loggedIn');
    $username = $sessionData['performed_by'];
    $ofmis_id = $sessionData['ofmis_id'];
    $role = $sessionData['role'];
    $user_id = $sessionData['user_id'] ?? null;

    foreach ($files as $file) {
        $file_name = $file->getClientOriginalName();

        $validator = Validator::make(['file' => $file], [
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip'
        ]);

        if ($validator->fails()) {
            $errors[] = [
                'file' => $file_name,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ];
            continue;
        }

        if (ProjectFile::where('project_id', $project_id)->where('file_name', $file_name)->exists()) {
            $errors[] = [
                'file' => $file_name,
                'message' => 'File already exists'
            ];
            continue;
        }

        try {
            $dynamicRoot = $this->getUploadPath();
            if (!$dynamicRoot) {
                return response()->json(['status' => 'error', 'message' => 'Upload path not configured.'], 500);
            }

            // Create folder if it doesn't exist
            if (!is_dir($dynamicRoot)) {
                try {
                    if (!@mkdir($dynamicRoot, 0777, true) && !is_dir($dynamicRoot)) {
                        throw new \RuntimeException("Unable to create directory at $dynamicRoot");
                    }
                } catch (\Throwable $e) {
                    Log::error("Failed to create upload directory", [
                        'path' => $dynamicRoot,
                        'error' => $e->getMessage()
                    ]);
            
                    return response()->json([
                        'status' => 'error',
                        'message' => "Directory creation failed: " . $e->getMessage()
                    ], 500);
                }
            }
            

            Log::info("Uploading to dynamic path", [
                'full_path' => $dynamicRoot,
                'file_name' => $file_name,
                'project_id' => $project_id,
                'uploaded_by' => $username
            ]);

            $disk = Storage::build([
                'driver' => 'local',
                'root' => $dynamicRoot,
            ]);

            $filepath = $disk->putFileAs('', $file, $file_name);

            if (!$filepath) {
                return response()->json(['error' => 'Upload failed'], 500);
            }

            ProjectFile::create([
                'project_id' => $project_id,
                'file_name' => $file_name,
                'file_id' => uniqid(),
                'action_by' => $username,
                'file_path' => $dynamicRoot // Add this field to DB if needed
            ]);
            

            $action = "Uploaded file: $file_name.";
            $request->session()->put('UploadedFile', [
                'user_id' => $user_id,
                'ofmis_id' => $ofmis_id,
                'performed_by' => $username,
                'role' => $role,
                'action' => $action,
            ]);

            (new ActivityLogs)->userAction($user_id, $ofmis_id, $username, $role, $action);

            $uploaded[] = $file_name;

        } catch (\Exception $e) {
            Log::error("Upload failed for {$file_name}", ['error' => $e->getMessage()]);

            $errors[] = [
                'file' => $file_name,
                'message' => 'Upload failed: ' . $e->getMessage()
            ];
        }
    }

    return response()->json([
        'status' => 'success',
        'uploaded' => $uploaded,
        'errors' => $errors
    ]);
}
public function getFiles($project_id)
{
    $uploadPath = $this->getUploadPath();
    if (!$uploadPath) {
        return response()->json(['status' => 'error', 'message' => 'Upload path not configured.'], 500);
    }

    $files = ProjectFile::where('project_id', $project_id)
        ->where('file_path', $uploadPath)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'status' => 'success',
        'files' => $files
    ]);
}

    


    // Delete a file by its file_name
    public function delete($file_name)
    {
        $file = ProjectFile::where('file_name', $file_name)->first();
    
        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
        }
    
        $dynamicRoot = $this->getUploadPath();
        if (!$dynamicRoot) {
            return response()->json(['status' => 'error', 'message' => 'Upload path not configured.'], 500);
        }
    
        $filePath = $dynamicRoot . DIRECTORY_SEPARATOR . $file_name;
    
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    
        $file->delete();
    
        return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
    }
    


    // Download a file by file_name
    public function downloadFile($file_name)
    {
        $dynamicRoot = $this->getUploadPath();
        if (!$dynamicRoot) {
            return response()->json(['status' => 'error', 'message' => 'Upload path not configured.'], 500);
        }
    
        $filePath = $dynamicRoot . DIRECTORY_SEPARATOR . $file_name;
    
        if (!file_exists($filePath)) {
            return response()->json(['status' => 'error', 'message' => 'File not found or inaccessible.'], 404);
        }
    
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'pdf'])) {
            return response()->file($filePath);
        }
    
        return response()->download($filePath);
    }
}
