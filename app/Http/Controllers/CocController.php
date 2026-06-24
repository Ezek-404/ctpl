<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coc;
use Illuminate\Support\Facades\DB;

class CocController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        // I-query ang database gamit ang search o kunin lahat
        $cocsQuery = Coc::query();

        if ($query) {
            $cocsQuery->where('coc_no', 'LIKE', "%{$query}%")
                    ->orWhere('coc_type', 'LIKE', "%{$query}%");
        }

        // Kung AJAX request, ibalik ang HTML partial
        if ($request->ajax()) {
            $cocs = $cocsQuery->latest()->get(); // Kunin lahat ng matching
            $html = view('partials.coc_table_rows', compact('cocs'))->render();
            return response()->json(['html' => $html]);
        }

        // Default: Paginate para sa main page load
        $cocs = $cocsQuery->latest()->paginate(15);
        return view('coc', compact('cocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_series' => 'required|numeric',
            'end_series' => 'required|numeric|gte:start_series', 
            'coc_type' => 'required|in:MC,TC,PC,CV',
        ], [
            'end_series.gte' => 'The end series must be greater than or equal to the start series.',
        ]);

        $series = range($request->start_series, $request->end_series);
        $totalAdded = count($series);

        // Check for duplicates
        if (\App\Models\Coc::whereIn('coc_no', $series)->exists()) {
            return redirect()->back()->withErrors(['error' => 'One or more COC numbers already exist in the database.']);
        }

        foreach ($series as $number) {
            \App\Models\Coc::create([
                'coc_no' => $number,
                'coc_type' => $request->coc_type,
                'coc_status' => 'Available',
            ]);
        }

        return redirect()->back()->with('success', "Success! {$totalAdded} COC series have been added.");
    }

    public function destroy($id)
    {
        $coc = Coc::where('coc_id', $id)->firstOrFail();
        $coc->delete();
        return redirect()->route('cocs.index')->with('success', 'Series deleted.');
    }
}