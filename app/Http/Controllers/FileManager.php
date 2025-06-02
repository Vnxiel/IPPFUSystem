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
    // Handle file upload for a specific project
    public function uploadFile(Request $request, $project_id)
    {
        // Log the incoming request for debugging
        Log::info("Upload Request Received", $request->all());

        // Check if files are present in the request
        if (!$request->hasFile('files')) {
            return response()->json(['status' => 'error', 'message' => 'No files uploaded.'], 400);
        }

        $files = $request->file('files');
        if (!is_array($files)) {
            $files = [$files]; // Ensure $files is always an array
        }

        $uploaded = [];
        $errors = [];

        // Check if the user is logged in via session
        if (!session()->has('loggedIn')) {
            return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
        }

        // Get user session data
        $sessionData = session()->get('loggedIn');
        $username = $sessionData['performed_by'];
        $ofmis_id = $sessionData['ofmis_id'];
        $role = $sessionData['role'];
        $user_id = $sessionData['user_id'] ?? null;

        // Process each file
        foreach ($files as $file) {
            $file_name = $file->getClientOriginalName();

            // Validate file type and size
            $validator = Validator::make(['file' => $file], [
                'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip'
            ]);

            // If validation fails, skip this file
            if ($validator->fails()) {
                $errors[] = [
                    'file' => $file_name,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ];
                continue;
            }

            // Check for duplicate file in DB for this project
            if (ProjectFile::where('project_id', $project_id)->where('file_name', $file_name)->exists()) {
                $errors[] = [
                    'file' => $file_name,
                    'message' => 'File already exists'
                ];
                continue;
            }

            try {
                // Store file in the "public/project_files" directory
                $filepath = $file->storeAs('project_files', $file_name, 'public');

                // Save file info to DB
                $projectFile = ProjectFile::create([
                    'project_id' => $project_id,
                    'file_name' => $file_name,
                    'file_id' => uniqid(),
                    'action_by' => $username,
                ]);

                // Prepare log action
                $action = "Uploaded file: $file_name.";
                $request->session()->put('UploadedFile', [
                    'user_id' => $user_id,
                    'ofmis_id' => $ofmis_id,
                    'performed_by' => $username,
                    'role' => $role,
                    'action' => $action,
                ]);

                // Log user action
                (new ActivityLogs)->userAction($user_id, $ofmis_id, $username, $role, $action);

                // Add file_name to success array
                $uploaded[] = $file_name;

            } catch (\Exception $e) {
                // Catch error and add to errors list
                $errors[] = [
                    'file' => $file_name,
                    'message' => 'Upload failed: ' . $e->getMessage()
                ];
            }
        }

        // Return upload status and results
        return response()->json([
            'status' => 'success',
            'uploaded' => $uploaded,
            'errors' => $errors
        ]);
    }

    // Retrieve files for a specific project
    public function getFiles($project_id)
    {
        // Get all files by project ID, newest first
        $files = ProjectFile::where('project_id', $project_id)
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
        // Find file record
        $file = ProjectFile::where('file_name', $file_name)->first();

        // If file doesn't exist, return error
        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
        }

        // Delete physical file from storage
        Storage::disk('public')->delete('project_files/' . $file->file_name);

        // Delete record from database
        $file->delete();

        return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
    }

    // Download a file by file_name
    public function downloadFile($file_name)
    {
        // Get file record
        $file = ProjectFile::where('file_name', $file_name)->first();

        // Check if DB record exists
        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File record not found.'], 404);
        }

        // Path to the physical file
        $filePath = storage_path('app/public/project_files/' . $file_name);

        // If file is not found in storage
        if (!file_exists($filePath)) {
            return response()->json(['status' => 'error', 'message' => 'File not found or inaccessible.'], 404);
        }

        // Check if file type can be previewed
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'pdf'])) {
            return response()->file($filePath); // View inline
        }

        // Otherwise, download the file
        return response()->download($filePath);
    }
}
