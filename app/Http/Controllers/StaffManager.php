<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ActivityLog;
use App\Models\Contractor;
use App\Models\ProjectDescription;
use App\Models\FundsUtilization;
use App\Models\ProjectFile;
use App\Models\ProjectStatus;
use App\Http\Controllers\ActivityLogs;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Municipality;

class StaffManager extends Controller
{
    public function index(){
        return view('staff.index');
    }

    public function projects(){
        return view('staff.projects');
    }
    public function overview(){
        return view('staff.overview');
    }

    public function contractorsList() {
        $contractors = Contractor::orderBy('name')->get(); // or any query you'd like
        return view('staff.projects', compact('contractors'));
    }
    public function getAllProjects()
    {
        $projects = Project::all();
    
        // Attach projectStatus from project_statuses to each project
        $projects->transform(function ($project) {
            $status = ProjectStatus::where('project_id', $project->id)->latest('created_at')->first();
            $project->projectStatus = $status ? $status->progress : null;
            return $project;
        });
    
        return response()->json([
            'status' => 'success',
            'projects' => $projects
        ]);
    }
}
