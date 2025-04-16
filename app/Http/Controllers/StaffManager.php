<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;


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
    


}
