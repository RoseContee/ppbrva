<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request) {
        return view('settings');
    }

    public function plans(Request $request) {
        return view('plans');
    }

    public function addplan(Request $request) {
        return view('add-plan');
    }
    
    public function roles(Request $request) {
        return view('roles');
    }

    public function addrole(Request $request) {
        return view('add-role');
    }
    
    public function appicons(Request $request) {
        return view('appicons');
    }    
}
