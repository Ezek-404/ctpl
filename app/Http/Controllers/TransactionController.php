<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = DB::table('ctpl_issuances')
            ->join('coc_table', 'ctpl_issuances.coc_id', '=', 'coc_table.coc_id')
            ->join('vehicles', 'ctpl_issuances.vehicle_id', '=', 'vehicles.vehicle_id')
            ->select(
                'ctpl_issuances.*', 
                'coc_table.coc_no', 
                'vehicles.plate_no' 
            )
            ->latest('ctpl_issuances.created_at')
            ->paginate(15);
        
        return view('transactions', compact('transactions'));
    }
}
