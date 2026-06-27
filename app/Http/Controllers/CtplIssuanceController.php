<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coc;
use App\Models\Vehicle;
use App\Models\CtplIssuance;
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

    public function getVehicleDetails(Request $request)
    {
        $type = $request->input('type');
        $value = $request->input('value');

        // 1. I-validate ang $type para iwasan ang SQL Injection
        $allowedColumns = ['plate_no', 'file_no', 'engine_no', 'chassis_no'];
        if (!in_array($type, $allowedColumns)) {
            return response()->json(['success' => false, 'message' => 'Invalid search parameter'], 400);
        }

        if (empty($value)) {
            return response()->json(['success' => false, 'message' => 'Search value is required'], 400);
        }

        // 2. Hanapin ang sasakyan
        // Gumamit ng first() at siguraduhing may result
        $vehicle = \App\Models\Vehicle::where($type, $value)->first();

        if (!$vehicle) {
            return response()->json(['success' => false, 'message' => 'Vehicle not found']);
        }

        // 3. Kunin ang pinakahuling issuance nang direkta
        // Mas mabilis ito kaysa sa with() kung isang sasakyan lang ang kailangan
        $latestIssuance = \App\Models\CtplIssuance::where('vehicle_id', $vehicle->vehicle_id)
                                                ->latest()
                                                ->first();

        // 4. Return the data
        return response()->json([
            'success' => true,
            'data' => [
                'assured'      => $latestIssuance->assured ?? '', // Null coalescing operator (mas malinis)
                'address'      => $latestIssuance->address ?? '',
                'year_model'   => $vehicle->year_model,
                'make'         => $vehicle->make,
                'series'       => $vehicle->series,
                'denomination' => $vehicle->denomination,
                'color'        => $vehicle->color,
                'plate_no'     => $vehicle->plate_no,
                'file_no'      => $vehicle->file_no,
                'engine_no'    => $vehicle->engine_no,
                'chassis_no'   => $vehicle->chassis_no,
            ]
        ]);
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
