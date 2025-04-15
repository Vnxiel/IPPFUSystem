<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function storeProjectID(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        Session::put('project_id', $request->id);

        return response()->json(['success' => true]);
    }

    public function getProjectID()
    {
        // Corrected key name here
        $project_id = Session::get('project_id');

        if (!$project_id) {
            return response()->json(['error' => 'No project ID found'], 404);
        }

        return response()->json(['project_id' => $project_id]);
    }
    
}

