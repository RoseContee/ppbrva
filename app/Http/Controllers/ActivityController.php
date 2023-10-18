<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index() {
        return view('activity.index');
    }

    public function create() {
        return view('activity.add-transaction');
    }
}
