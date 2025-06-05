<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectDescription;
use App\Models\FundsUtilization;
use App\Models\VariationOrder;
use App\Models\ReportSignatory;
use App\Models\ProjectTimeExtension;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class GenerateProjectReport extends Controller
{
    public function generateProjectPDF(Request $request, $project_id)
    {
        try {
            Log::info("Generating PDF for Project ID: " . $project_id);
            $type = $request->query('type', 'data');

            $project = Project::findOrFail($project_id);

            if ($project->source_of_funds === 'Others') {
                $project->source_of_funds = $project->otherFund;
            }
            if ($project->firm_name === 'Others') {
                $project->firm_name = $project->othersContractor;
            }

            // ✅ Activity logging
            if (session()->has('loggedIn')) {
                $sessionData = session()->get('loggedIn');
                $reportType = $type === 'timeline' ? 'Timeline Report' : 'Project Report';
                $action = "Generated {$reportType} for '{$project->title}'";

                $request->session()->put('GeneratedReport', [
                    'user_id' => $sessionData['user_id'],
                    'ofmis_id' => $sessionData['ofmis_id'],
                    'performed_by' => $sessionData['performed_by'],
                    'role' => $sessionData['role'],
                    'action' => $action,
                ]);

                Log::info("User action logged: " . json_encode($request->session()->get('GeneratedReport')));

                (new ActivityLogs)->userAction(
                    $sessionData['user_id'],
                    $sessionData['ofmis_id'],
                    $sessionData['performed_by'],
                    $sessionData['role'],
                    $action
                );
            }

            $description = ProjectDescription::where('project_id', $project_id)
                ->pluck('description')
                ->toArray();

            $projectFundsUtilization = FundsUtilization::where('project_id', $project_id)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($projectFundsUtilization) {
                Log::info('Funds Utilization found for Project ID ' . $project_id . ':', $projectFundsUtilization->toArray());
            } else {
                Log::info('No Funds Utilization found for Project ID ' . $project_id);
            }

            $projectVariationOrder = $projectFundsUtilization
                ? VariationOrder::where('funds_utilization_id', $projectFundsUtilization->id)->get()
                : [];

            Log::info('Variation Orders count: ' . count($projectVariationOrder));
            if (!empty($projectVariationOrder)) {
                foreach ($projectVariationOrder as $vo) {
                    Log::info('Variation Order:', $vo->toArray());
                }
            }

            $projectFileNames = ProjectFile::where('project_id', $project_id)
                ->where(function ($query) {
                    $query->whereRaw('LOWER(file_name) LIKE ?', ['%.jpg'])
                          ->orWhereRaw('LOWER(file_name) LIKE ?', ['%.jpeg'])
                          ->orWhereRaw('LOWER(file_name) LIKE ?', ['%.png'])
                          ->orWhereRaw('LOWER(file_name) LIKE ?', ['%.gif']);
                })
                ->pluck('file_name')
                ->toArray();

            $user = auth()->user();
            $userPosition = $user->position ?? 'Unknown Position';

            $projectFiles = array_map(function ($file_name) {
                $path = storage_path('app/public/project_files/' . $file_name);
                if (file_exists($path)) {
                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                    $base64 = base64_encode(file_get_contents($path));
                    return [
                        'name' => $file_name,
                        'data' => "data:image/{$extension};base64,{$base64}",
                    ];
                }
                return null;
            }, $projectFileNames);

            $projectFiles = array_filter($projectFiles); // Remove nulls

            Log::info('Base64-encoded image count: ' . count($projectFiles));

            $type = $request->input('type', 'data'); // fallback if missing
            $withPictures = $request->boolean('with_pictures');

            $view = match ($type) {
                'timeline' => $withPictures ? 'pdf.timelineReportWithPicNew' : 'pdf.timelineReport',
                'data' => $withPictures ? 'pdf.generateProjectWithPicNew' : 'pdf.generateProject',
                default => 'pdf.generateProject',
            };

            $signatory = ReportSignatory::where('project_id', $project_id)->first();
            $reviewedBy = $signatory->reviewed_by ?? '';
            $reviewedByPosition = $signatory->reviewed_by_position ?? '';
            $notedBy = $signatory->noted_by ?? '';
            $notedByPosition = $signatory->noted_by_position ?? '';

            $timeExtensions = ProjectTimeExtension::where('project_id', $project_id)->get();

            $pdf = Pdf::loadView($view, [
                'project' => $project,
                'description' => $description,
                'time_extensions' => $timeExtensions,
                'projectFundsUtilization' => $projectFundsUtilization,
                'projectVariationOrder' => $projectVariationOrder,
                'projectFiles' => $projectFiles,
                'userName' => $user ? $user->fullname : 'Unknown User',
                'userPosition' => $userPosition,
                'reviewedBy' => $reviewedBy,
                'reviewed_by_position' => $reviewedByPosition,
                'notedBy' => $notedBy,
                'noted_by_position' => $notedByPosition,
                'printedAt' => now()->format('F j, Y g:i A'),
            ])
            ->setPaper([0, 0, 612, 936], 'portrait');

            $sanitizedTitle = preg_replace('/[\/\\\\]/', '_', $project->title);
            return $pdf->stream("Project_{$sanitizedTitle}.pdf");

        } catch (\Exception $e) {
            Log::error("PDF Generation Error: " . $e->getMessage());
            return back()->with('error', 'Failed to generate project PDF.');
        }
    }
}
