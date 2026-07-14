<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('ctpl_issuances')
            ->join('coc_table', 'ctpl_issuances.coc_id', '=', 'coc_table.coc_id')
            ->join('vehicles', 'ctpl_issuances.vehicle_id', '=', 'vehicles.vehicle_id')
            ->select(
                'ctpl_issuances.transaction_id as unique_tx_id', 
                'ctpl_issuances.assured',
                'ctpl_issuances.created_at', 
                'coc_table.coc_no', 
                'vehicles.plate_no' 
            );

        // Apply Server-Side Search filters if active
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('ctpl_issuances.transaction_id', 'LIKE', "%{$search}%")
                  ->orWhere('ctpl_issuances.assured', 'LIKE', "%{$search}%")
                  ->orWhere('vehicles.plate_no', 'LIKE', "%{$search}%")
                  ->orWhere('coc_table.coc_no', 'LIKE', "%{$search}%");
            });
        }

        $transactions = $query->latest('ctpl_issuances.created_at')
    ->simplePaginate(15) // <-- Changes pagination to "Prev/Next" links instead of counting all 3,751 records
    ->withQueryString();

        // If AJAX request, return the raw table partial component
        if ($request->ajax()) {
            return view('partials.transactions_table', compact('transactions'))->render();
        }
        
        return view('transactions', compact('transactions'));
    }
}
