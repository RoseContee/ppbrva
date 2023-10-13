<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        return view('locations', [
            'user' => $request->user(),
        ]);
    } 


    public function add(Request $request) {
        return view('add-location', [
            'user' => $request->user(),
        ]);
    }
}
