<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        return view('members', [
            'user' => $request->user(),
        ]);
    }

    public function add(Request $request)
    {
        return view('add-member', [
            'user' => $request->user(),
        ]);
    }    

    public function activity(Request $request)
    {
        return view('activity', [
            'user' => $request->user(),
        ]);
    }

    public function addActivity(Request $request)
    {
        return view('add-transaction', [
            'user' => $request->user(),
        ]);
    }    

    public function invoices(Request $request)
    {
        return view('invoices', [
            'user' => $request->user(),
        ]);
    }    


    public function invoicedetail(Request $request)
    {
        return view('invoice-detail', [
            'user' => $request->user(),
        ]);
    }        

}
