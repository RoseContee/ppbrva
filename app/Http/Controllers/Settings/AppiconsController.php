<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppiconsController extends Controller
{
    public function index() {
        return view('settings.appicons.index');
    }
}
