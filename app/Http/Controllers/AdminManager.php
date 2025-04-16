<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminManager extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function projects(){
        return view('admin.projects');
    }
    public function userManagement(){
        return view('admin.userManagement');
    }    
    public function overview(){
        return view('admin.overview');
    }    

    public function trash(){
        return view('admin.trash');
    }    


    public function temporaryDeleteProject(Request $request){

    }

    public function restoreProject(Request $request){

    }

    public function viewProjectStatus(Request $request){

    }
}
