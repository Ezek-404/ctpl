<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function stats()
    {
        // Define your active target status string (e.g., 'Available' or 'Unused')
        $targetStatus = 'Available'; 

        // Fetch counts for remaining certificates of coverages
        $mcRemaining = DB::table('coc_table')->where('coc_type', 'MC')->where('coc_status', $targetStatus)->count();
        $pcRemaining = DB::table('coc_table')->where('coc_type', 'PC')->where('coc_status', $targetStatus)->count();
        $tcRemaining = DB::table('coc_table')->where('coc_type', 'TC')->where('coc_status', $targetStatus)->count();
        $cvRemaining = DB::table('coc_table')->where('coc_type', 'CV')->where('coc_status', $targetStatus)->count();

        // Pass numbers directly to the stats view layout
        return view('stats', compact('mcRemaining', 'pcRemaining', 'tcRemaining', 'cvRemaining'));
    }
}