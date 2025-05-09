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

                $projectFundsUtilization = FundsUtilization::where('project_id', $project_id)
                ->orderBy('updated_at', 'desc')
                ->first();

             $projectVariationOrder = $projectFundsUtilization
                ? VariationOrder::where('funds_utilization_id', $projectFundsUtilization->id)->get()
                : [];

           

            $projectFileNames = ProjectFile::where('project_id', $project_id)
                ->where(function ($query) {
                    $query->whereRaw('LOWER(fileName) LIKE ?', ['%.jpg'])
                          ->orWhereRaw('LOWER(fileName) LIKE ?', ['%.jpeg'])
                          ->orWhereRaw('LOWER(fileName) LIKE ?', ['%.png'])
                          ->orWhereRaw('LOWER(fileName) LIKE ?', ['%.gif']);
                })
                ->pluck('fileName')
                ->toArray();

                $user = auth()->user();


            // Convert images to base64 for reliable DomPDF embedding
            $projectFiles = array_map(function ($fileName) {
                $path = storage_path('app/public/project_files/' . $fileName);
                if (file_exists($path)) {
                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                    $base64 = base64_encode(file_get_contents($path));
                    return [
                        'name' => $fileName,
                        'data' => "data:image/{$extension};base64,{$base64}",
                    ];
                }
                return null;
            }, $projectFileNames);

            $projectFiles = array_filter($projectFiles); // Remove nulls

            Log::info('Base64-encoded image count: ' . count($projectFiles));

            $view = $request->boolean('with_pictures')
                ? 'pdf.generateProjectWithPicNew'
                : 'pdf.generateProject';

            $user = auth()->user();

            $pdf = Pdf::loadView($view, [
                'project' => $project,
                'projectDescriptions' => $projectDescriptions,
                'projectFundsUtilization' => $projectFundsUtilization,
                'projectVariationOrder' => $projectVariationOrder,
                'projectFiles' => $projectFiles,
                'userName' => $user ? $user->fullname : 'Unknown User',
            ])->setPaper([0, 0, 612, 936], 'portrait');

            $sanitizedTitle = preg_replace('/[\/\\\\]/', '_', $project->projectTitle);
            return $pdf->stream("Project_{$sanitizedTitle}.pdf");

        } catch (\Exception $e) {
            Log::error("PDF Generation Error: " . $e->getMessage());
            return back()->with('error', 'Failed to generate project PDF.');
        }
    }
}
