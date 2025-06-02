<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTimeExtension;

class ProjectTimeExtensionController extends Controller
{
    // Insert time extension
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'time_extension_no' => 'required|unique:project_time_extension,time_extension_no',
            'time_extension_reason' => 'nullable|string',
            'revised_expiry' => 'nullable|date',
            'revised_expiry_reason' => 'nullable|string',
            'total_extension_granted' => 'nullable|integer',
            'total_revised_contract_time' => 'nullable|integer',
        ]);

        $extension = ProjectTimeExtension::create($validated);

        return response()->json([
            'message' => 'Time extension added successfully.',
            'data' => $extension
        ], 201);
    }

    // Fetch all extensions
    public function index()
    {
        $extensions = ProjectTimeExtension::with('project')->get();

        return response()->json($extensions);
    }

    // Optional: Fetch extensions by project ID
    public function showByProject($projectId)
    {
        $extensions = ProjectTimeExtension::where('project_id', $projectId)->get();

        return response()->json($extensions);
    }
}
