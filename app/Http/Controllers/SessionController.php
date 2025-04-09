<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function storeProjectID(Request $request)
    {
        $request->validate([
            'projectID' => 'required'
        ]);

        Session::put('projectID', $request->projectID);

        return response()->json(['success' => true]); // Ensure response is JSON
    }

    public function getProjectID()
    {
        $projectID = Session::get('projectID');

        if (!$projectID) {
            return response()->json(['error' => 'No project ID found'], 404);
        }

        return response()->json(['projectID' => $projectID]);
    }

}

