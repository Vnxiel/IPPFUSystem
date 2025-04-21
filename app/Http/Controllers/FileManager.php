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

    if (!$request->hasFile('files')) {
        return response()->json(['status' => 'error', 'message' => 'No files uploaded.'], 400);
    }

    $files = $request->file('files');
    if (!is_array($files)) {
        $files = [$files]; // Ensure it's an array
    }

    $uploaded = [];
    $errors = [];

    // Session data
    if (!session()->has('loggedIn')) {
        return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
    }

    $sessionData = session()->get('loggedIn');
    $username = $sessionData['performedBy'];
    $ofmis_id = $sessionData['ofmis_id'];
    $role = $sessionData['role'];
    $user_id = $sessionData['user_id'] ?? null;

    foreach ($files as $file) {
        $filename = $file->getClientOriginalName();

        $validator = Validator::make(['file' => $file], [
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip'
        ]);

        if ($validator->fails()) {
            $errors[] = [
                'file' => $filename,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ];
            continue;
        }

        // Check for duplicate
        if (ProjectFile::where('project_id', $project_id)->where('fileName', $filename)->exists()) {
            $errors[] = [
                'file' => $filename,
                'message' => 'File already exists'
            ];
            continue;
        }

        try {
            $timestampedFilename = date('Ymd_His') . '_' . $filename;
            $filepath = $file->storeAs('project_files', $filename, 'public');

            $projectFile = ProjectFile::create([
                'project_id' => $project_id,
                'fileName' => $filename,
                'fileID' => uniqid(),
                'actionBy' => $username,
            ]);

            $action = "Uploaded file: $filename.";
            $request->session()->put('UploadedFile', [
                'user_id' => $user_id,
                'ofmis_id' => $ofmis_id,
                'performedBy' => $username,
                'role' => $role,
                'action' => $action,
            ]);

            (new ActivityLogs)->userAction($user_id, $ofmis_id, $username, $role, $action);

            $uploaded[] = $filename;
        } catch (\Exception $e) {
            $errors[] = [
                'file' => $filename,
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
    public function delete($fileName)
    {
        $file = ProjectFile::where('fileName', $fileName)->first();
    
        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
        }
    
        // Delete the physical file
        Storage::disk('public')->delete('project_files/' . $file->fileName);
    
        // Delete the DB record
        $file->delete();
    
        return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
    }
    
    public function downloadFile($filename)
{
    $file = ProjectFile::where('fileName', $filename)->first();

    if (!$file) {
        return response()->json(['status' => 'error', 'message' => 'File record not found.'], 404);
    }

    // New correct path (if using storage:link)
    $filePath = public_path('storage/project_files/' . $filename);

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
