<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'vehicle_id'   => $vehicle->vehicle_id,
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

    public function store(Request $request)
    {
        // 1. I-validate ang input
        $validatedData = $request->validate([
            'assured'       => 'required|string',
            'address'       => 'required|string',
            'year_model'    => 'required|integer',
            'make'          => 'required|string',
            'series'        => 'required|string',
            'color'         => 'required|string',
            'file_no'       => 'required|string',
            'plate_no'      => 'required|string',
            'engine_no'     => 'required|string',
            'chassis_no'    => 'required|string',
            'denomination'  => 'required|string',
            'coc_number'    => 'required|string',
            'policy_number' => 'required|string',
            'agent'         => 'required|string',
            'amount'        => 'required|numeric',
        ]);

        // 2. I-transform ang text inputs sa UPPERCASE
        $request->merge([
            'assured'    => strtoupper($request->assured),
            'address'    => strtoupper($request->address),
            'make'       => strtoupper($request->make),
            'series'     => strtoupper($request->series),
            'color'      => strtoupper($request->color),
            'file_no'    => strtoupper($request->file_no),
            'plate_no'   => strtoupper($request->plate_no),
            'engine_no'  => strtoupper($request->engine_no),
            'chassis_no' => strtoupper($request->chassis_no),
            'agent'      => strtoupper($request->agent),
        ]);

        try {
        // I-return ang resulta ng transaction direkta
        $issuance = DB::transaction(function () use ($request) {
            
            $vehicle = Vehicle::updateOrCreate(
                ['file_no' => $request->file_no],
                [
                    'year_model'   => $request->year_model,
                    'make'         => $request->make,
                    'series'       => $request->series,
                    'color'        => $request->color,
                    'plate_no'     => $request->plate_no,
                    'engine_no'    => $request->engine_no,
                    'chassis_no'   => $request->chassis_no,
                    'denomination' => $request->denomination,
                ]
            );

            $coc = Coc::where('coc_no', $request->coc_number)
                      ->where('coc_status', 'Available')
                      ->firstOrFail();
            
            $coc->update(['coc_status' => 'Used']);

            return CtplIssuance::create([
                'policy_no'  => $request->policy_number,
                'assured'    => $request->assured,
                'address'    => $request->address,
                'agent'      => $request->agent,
                'amount'     => $request->amount,
                'coc_id'     => $coc->coc_id,
                'vehicle_id' => $vehicle->vehicle_id,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Transaction Successful!',
            'data'    => $issuance
        ]);

    } catch (\Exception $e) {
        // Kung may error, ibalik ang error message
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
    }

    public function print($id)
    {
        $issuance = CtplIssuance::with(['vehicle', 'coc'])->findOrFail($id);

        $view = 'print.pc'; 

        return view($view, compact('issuance'));
    }
    
}
