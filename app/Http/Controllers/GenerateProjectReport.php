<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Project; 
use App\Models\ProjectFile; 
use App\Models\ProjectDescription; 
use App\Models\FundsUtilization; 
use App\Models\VariationOrder; 
use Illuminate\Support\Facades\Log;

class GenerateProjectReport extends Controller
{
    public function generateProjectPDF($project_id)
{
    try {
        Log::info("Generating PDF for Project ID: " . $project_id);

        // Fetch project details
        $project = Project::find($project_id);
        if (!$project) {
            Log::error("Project not found with ID: " . $project_id);
            return back()->with('error', 'Project not found.');
        }

        // Replace 'Others' values with actual input from otherFund and othersContractor
        if ($project->sourceOfFunds === 'Others') {
            $project->sourceOfFunds = $project->otherFund;
        }
        if ($project->projectContractors === 'Others') {
            $project->projectContractors = $project->othersContractor;
        }

        // Fetch all related descriptions
        $projectDescriptions = ProjectDescription::where('project_id', $project_id)
            ->pluck('ProjectDescription')
            ->toArray();

        Log::info("Fetched " . count($projectDescriptions) . " project descriptions for Project ID: " . $project_id);
        foreach ($projectDescriptions as $index => $desc) {
            Log::info("Description " . ($index + 1) . ": " . $desc);
        }

        // Fetch funds utilization and related variation orders
        $projectFundsUtilization = FundsUtilization::where('project_id', $project_id)->first();
        $projectVariationOrder = [];
        if ($projectFundsUtilization) {
            $projectVariationOrder = VariationOrder::where('funds_utilization_id', $projectFundsUtilization->id)->get();
        }

        // Fetch uploaded files
        $projectFiles = ProjectFile::where('project_id', $project_id)->get();

        Log::info("Project data prepared for PDF generation.");

        // Sanitize title
        $sanitizedTitle = preg_replace('/[\/\\\\]/', '_', $project->projectTitle);

        // Load PDF
        $pdf = Pdf::loadView('pdf.generateProject', [
            'project' => $project,
            'projectDescriptions' => $projectDescriptions, // ✅ now properly passed
            'projectFundsUtilization' => $projectFundsUtilization,
            'projectVariationOrder' => $projectVariationOrder,
            'projectFiles' => $projectFiles,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("Project_{$sanitizedTitle}.pdf");

    } catch (\Exception $e) {
        Log::error("PDF Generation Error: " . $e->getMessage());
        return back()->with('error', 'Failed to generate project PDF.');
    }
}

}
