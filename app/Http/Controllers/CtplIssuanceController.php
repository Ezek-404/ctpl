<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coc;
use App\Models\Vehicle;
use App\Models\CtplIssuance;
use Illuminate\Support\Str;
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

        // 2. I-transform ang text inputs sa UPPERCASE gamit ang validated array
        $validatedData['assured']    = strtoupper($validatedData['assured']);
        $validatedData['address']    = strtoupper($validatedData['address']);
        $validatedData['make']       = strtoupper($validatedData['make']);
        $validatedData['series']     = strtoupper($validatedData['series']);
        $validatedData['color']      = strtoupper($validatedData['color']);
        $validatedData['file_no']    = strtoupper($validatedData['file_no']);
        $validatedData['plate_no']   = strtoupper($validatedData['plate_no']);
        $validatedData['engine_no']  = strtoupper($validatedData['engine_no']);
        $validatedData['chassis_no'] = strtoupper($validatedData['chassis_no']);
        $validatedData['agent']      = strtoupper($validatedData['agent']);

        try {
            // Gumawa ng ligtas na numeric Transaction ID na kasya sa standard Integer range (7 to 9 digits)
            // Ito ay upang maiwasan ang auto-conversion sa 0 sanhi ng data size overflow
            $generatedTransactionId = str_pad(rand(1000000, 999999999), 9, '0', STR_PAD_LEFT);

            $issuance = DB::transaction(function () use ($validatedData, $generatedTransactionId) {
                
                // Hanapin o i-update ang Vehicle record
                $vehicle = Vehicle::updateOrCreate(
                    ['file_no' => $validatedData['file_no']],
                    [
                        'year_model'   => $validatedData['year_model'],
                        'make'         => $validatedData['make'],
                        'series'       => $validatedData['series'],
                        'color'        => $validatedData['color'],
                        'plate_no'     => $validatedData['plate_no'],
                        'engine_no'    => $validatedData['engine_no'],
                        'chassis_no'   => $validatedData['chassis_no'],
                        'denomination' => $validatedData['denomination'],
                    ]
                );

                // Suriin kung ang COC ay available
                $coc = Coc::where('coc_no', $validatedData['coc_number'])
                        ->where('coc_status', 'Available')
                        ->firstOrFail();
                
                $coc->update(['coc_status' => 'Used']);

                // I-save ang CtplIssuance na may kasamang generated transaction id
                return CtplIssuance::create([
                    'policy_no'      => $validatedData['policy_number'],
                    'assured'        => $validatedData['assured'],
                    'address'        => $validatedData['address'],
                    'agent'          => $validatedData['agent'],
                    'amount'         => $validatedData['amount'],
                    'coc_id'         => $coc->coc_id,
                    'vehicle_id'     => $vehicle->vehicle_id,
                    'transaction_id' => $generatedTransactionId, 
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaction successful!',
                'data' => [
                    // Direktang ibalik ang string variable para makasiguro na hindi ito magiging 0 sa AJAX response
                    'transaction_id' => $generatedTransactionId 
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function print($id) {
        // Isama ang 'coc' sa eager loading at maghanap gamit ang 'transaction_id'
        $issuance = CtplIssuance::with(['vehicle', 'coc'])
            ->where('transaction_id', $id)
            ->firstOrFail();
            
        // Gawin nating lowercase ang database value para sigurado
        $type = strtolower(trim($issuance->vehicle->denomination ?? '')); 

        $view = match ($type) {
            'mc', 'mtc' => 'print.mc',
            
            'car', 'passenger car', 'hatchback', 'sedan', 'utility vehicle', 
            'suv', 'coupe', 'subcompact' => 'print.pc',
            
            'tricycle' => 'print.tc',
            
            'truck', 'trailer' => 'print.cv',
            
            default => 'print.pc',
        };

        return view($view, compact('issuance'));
    }
    
}
