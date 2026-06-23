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

        if ($request->ajax()) {
            // Mag-filter gamit ang query
            $cocs = Coc::where('coc_no', 'LIKE', "%{$query}%")
                        ->orWhere('coc_type', 'LIKE', "%{$query}%")
                        ->get();

            $html = '';
            if ($cocs->count() > 0) {
                foreach ($cocs as $coc) {
                    $statusClass = $coc->coc_status === 'Used' ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/20' : 'bg-zinc-900 text-zinc-400 border border-zinc-700/30';
                    
                    $html .= "<tr class='hover:bg-zinc-900/20 transition-colors'>
                        <td class='px-6 py-3.5 text-xs font-medium text-zinc-500'>{$coc->coc_id}</td>
                        <td class='px-6 py-3.5 text-xs font-bold text-zinc-200 tracking-wide'>{$coc->coc_no}</td>
                        <td class='px-6 py-3.5 text-xs font-semibold text-zinc-400'>{$coc->coc_type}</td>
                        <td class='px-6 py-3.5 text-xs'>
                            <span class='inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold tracking-wider uppercase {$statusClass}'>
                                {$coc->coc_status}
                            </span>
                        </td>
                        <td class='px-6 py-3.5 text-xs font-medium text-zinc-400'>{$coc->created_at}</td>
                    </tr>";
                }
            } else {
                $html .= "<tr>
                    <td colspan='5' class='px-6 py-8 text-center text-xs text-zinc-500 uppercase tracking-widest'>
                        No Certificate Logs Found in Database Registry
                    </td>
                </tr>";
            }

            return response()->json(['html' => $html]);
        }

        // Default view loading standard pagination flow 
        $cocs = Coc::latest()->paginate(15);
        return view('coc', compact('cocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_series' => 'required|numeric',
            'end_series' => 'required|numeric|gte:start_series',
            'coc_type' => 'required|in:MC,TC,PC,CV',
        ]);

        // Loop para i-create ang bawat record sa series
        for ($i = $request->start_series; $i <= $request->end_series; $i++) {
            \App\Models\Coc::create([
                'coc_no' => $i,
                'coc_type' => $request->coc_type,
                'coc_status' => 'Available',
            ]);
        }

        return redirect()->back()->with('success', 'Series added successfully!');
    }

    public function destroy($id)
    {
        $coc = Coc::where('coc_id', $id)->firstOrFail();
        $coc->delete();
        return redirect()->route('cocs.index')->with('success', 'Series deleted.');
    }
}