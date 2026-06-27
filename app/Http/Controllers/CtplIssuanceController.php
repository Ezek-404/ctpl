<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coc;
class CtplIssuanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Siguraduhin na ang file ay nasa resources/views/issuance.blade.php
        return view('ctpl-issuance', compact('user'));
    }

    public function checkCoc(Request $request)
    {
        $cocNumber = $request->input('coc_number');
        $selection = $request->input('denomination'); // Halimbawa: 'SEDAN'

        // I-map ang selection sa tamang coc_type sa DB
        $map = [
            'MC' => 'MC', 'MTC' => 'MC',
            'CAR' => 'PC', 'PASSENGER CAR' => 'PC', 'SEDAN' => 'PC', 'HATCHBACK' => 'PC', 
            'UTILITY VEHICLE' => 'PC', 'SUV' => 'PC', 'COUPE' => 'PC',
            'TRICYCLE' => 'TC',
            'TRUCK' => 'CV', 'TRAILER' => 'CV'
        ];

        $cocType = $map[$selection] ?? null;

        if (!$cocType) {
            return response()->json(['available' => false]);
        }

        $exists = Coc::where('coc_no', $cocNumber)
                    ->where('coc_type', $cocType)
                    ->where('coc_status', 'Available')
                    ->exists();

        return response()->json(['available' => $exists]);
    }
    
    public function store()
    {
        $request->validate([
            'assured_name'   => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'year_model'     => 'required|digits:4',
            'make'           => 'required|string|max:50',
            'series'         => 'required|string|max:50',
            'color'          => 'required|string|max:50',
            'mv_file'        => 'required|digits:15',
            'plate_number'   => 'required|string|max:7',
            'engine_number'  => 'required|string|max:50',
            'chassis_number' => 'required|string|max:50',
            'denomination'   => 'required|string',
            'coc_number'     => 'required|numeric',
            'policy_number'  => 'required|numeric',
            'agent'          => 'required|string',
            'amount'         => 'required|numeric',
        ]);

       return redirect()->route('dashboard.ctpl-issuance')->with('success', 'Policy issued successfully!');
    }
}
