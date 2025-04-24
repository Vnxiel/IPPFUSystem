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
    public function generateProjectPDF(Request $request, $project_id)
    {
        try {
            Log::info("Generating PDF for Project ID: " . $project_id);

            $project = Project::findOrFail($project_id);

            if ($project->sourceOfFunds === 'Others') {
                $project->sourceOfFunds = $project->otherFund;
            }
            if ($project->projectContractor === 'Others') {
                $project->projectContractor = $project->othersContractor;
            }

            $projectDescriptions = ProjectDescription::where('project_id', $project_id)
                ->pluck('ProjectDescription')
                ->toArray();

            $projectFundsUtilization = FundsUtilization::where('project_id', $project_id)->first();
            $projectVariationOrder = $projectFundsUtilization
                ? VariationOrder::where('funds_utilization_id', $projectFundsUtilization->id)->get()
                : [];

                $projectFiles = ProjectFile::where('project_id', $project_id)
                ->pluck('fileName')
                ->toArray();
            

            $view = $request->boolean('with_pictures')
                ? 'pdf.generateProjectWithPic'
                : 'pdf.generateProject';

            $user = auth()->user();

            $pdf = Pdf::loadView($view, [
                'project' => $project,
                'projectDescriptions' => $projectDescriptions,
                'projectFundsUtilization' => $projectFundsUtilization,
                'projectVariationOrder' => $projectVariationOrder,
                'projectFiles' => $projectFiles,
                'userName' => $user ? $user->fullname : 'Unknown User',
            ])->setPaper('A4', 'portrait');

            $sanitizedTitle = preg_replace('/[\/\\\\]/', '_', $project->projectTitle);
            return $pdf->stream("Project_{$sanitizedTitle}.pdf");

        } catch (\Exception $e) {
            Log::error("PDF Generation Error: " . $e->getMessage());
            return back()->with('error', 'Failed to generate project PDF.');
        }
    }
}
