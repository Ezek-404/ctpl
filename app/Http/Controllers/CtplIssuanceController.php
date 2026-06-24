<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CtplIssuanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Siguraduhin na ang file ay nasa resources/views/issuance.blade.php
        return view('ctpl-issuance', compact('user'));
    }
    
    public function store()
    {
       return redirect()->route('dashboard.ctpl-issuance')->with('success', 'Policy issued successfully!');
    }
}
