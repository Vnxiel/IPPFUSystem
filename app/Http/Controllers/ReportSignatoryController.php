<?php

// app/Http/Controllers/ReportSignatoryController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportSignatory;

class ReportSignatoryController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'project_id' => 'required|integer|exists:projects,id',
        'reviewed_by' => 'required|string',
        'reviewed_by_position' => 'required|string',
        'noted_by' => 'required|string',
        'noted_by_position' => 'required|string',
    ]);

    $signatory = ReportSignatory::updateOrCreate(
        ['project_id' => $data['project_id']],
        [
            'reviewed_by' => $data['reviewed_by'],
            'reviewed_by_position' => $data['reviewed_by_position'],
            'noted_by' => $data['noted_by'],
            'noted_by_position' => $data['noted_by_position'],
        ]
    );

    return response()->json(['message' => 'Signatories saved successfully.']);
}

    public function index()
    {
        return ReportSignatory::all();
    }

    public function getByProject($project_id)
    {
        return ReportSignatory::where('project_id', $project_id)->first();
    }
}
