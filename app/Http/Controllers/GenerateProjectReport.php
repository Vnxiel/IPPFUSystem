<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Project; // Ensure you import the correct model
use Illuminate\Support\Facades\Log;

class GenerateProjectReport extends Controller
{
    public function generateProjectPDF($project_id)
{
    try {
        Log::info("Generating PDF for Project ID: " . $project_id);

        // Fetch project details
        $project = Project::where('id', $project_id)->first();

        if (!$project) {
            Log::error("Project not found with ID: " . $project_id);
            return back()->with('error', 'Project not found.');
        }

        Log::info("Project found: " . json_encode($project));

       // Load the Blade view into PDF
        $pdf = Pdf::loadView('pdf.generateProject', compact('project'))
        ->setPaper('A4', 'portrait'); // Set A4 paper size

        return $pdf->stream("Project_{$project->projectTitle}.pdf");

    } catch (\Exception $e) {
        Log::error("PDF Generation Error: " . $e->getMessage());
        return back()->with('error', 'Failed to generate project PDF.');
    }
}
}
