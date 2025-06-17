<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
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

        if (!session()->has('loggedIn')) {
            return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
        }

        $sessionData = session()->get('loggedIn');
        $username = $sessionData['performed_by'];
        $ofmis_id = $sessionData['ofmis_id'];
        $role = $sessionData['role'];
        $user_id = $sessionData['user_id'] ?? null;

        $uploaded = [];
        $errors = [];

        foreach ($files as $file) {
            $file_name = $file->getClientOriginalName();

            $validator = Validator::make(['file' => $file], [
                'file' => 'required|file|max:102400|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip'
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
                $customPath = trim($request->input('custom_path', 'project_files'), '/');
                $filepath = $file->storeAs($customPath, $file_name, 'public');

                if (!$filepath) {
                    return response()->json(['error' => 'Upload failed'], 500);
                }

                ProjectFile::create([
                    'project_id' => $project_id,
                    'file_name' => $file_name,
                    'file_id' => uniqid(),
                    'action_by' => $username,
                    'file_path' => $filepath
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
        $files = ProjectFile::where('project_id', $project_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'files' => $files
        ]);
    }

    public function delete($file_name)
    {
        $file = ProjectFile::where('file_name', $file_name)->first();

        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
        }

        $filePath = $file->file_path;

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $file->delete();

        return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
    }

    public function downloadFile($file_name)
    {
        $file = ProjectFile::where('file_name', $file_name)->first();

        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
        }

        $filePath = $file->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['status' => 'error', 'message' => 'File not found or inaccessible.'], 404);
        }

        $fullPath = storage_path('app/public/' . $filePath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'pdf'])) {
            return response()->file($fullPath);
        }

        return response()->download($fullPath);
    }
}
