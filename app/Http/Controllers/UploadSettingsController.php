<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadSetting;

class UploadSettingsController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'upload_path' => 'required|string|max:255',
    ]);

    UploadSetting::create([
        'upload_path' => $request->upload_path,
    ]);

    return response()->json(['message' => 'Upload path saved successfully']);
}

public function fetchAll()
{
    $paths = UploadSetting::orderBy('created_at', 'desc')
                ->pluck('upload_path')
                ->unique()
                ->values(); // reindex the collection

    return response()->json(['paths' => $paths]);
}


}
