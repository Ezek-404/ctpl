@extends('layouts.app')

@section('title', 'CTPL Portal - COC Management')

@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Return to Main Hub</span>
    </a>
@endsection

@section('content')
    <div class="w-full flex flex-col items-stretch -mt-6">
        
        <div class="flex flex-col items-center text-center mb-6">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-slate-900 to-slate-850 border border-zinc-700/60 flex items-center justify-center shadow-lg mb-3">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="text-white text-xl font-black tracking-wide uppercase leading-tight">COC Management</h1>
            <p class="text-zinc-500 text-[10px] font-normal tracking-widest mt-1 uppercase">Real-time monitoring and authentication repository</p>
        </div>

        <div class="w-full bg-[#161d30]/70 border border-zinc-800/80 rounded-lg p-6 shadow-2xl backdrop-blur-sm">
            
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-4 border-b border-zinc-800/60 mb-4">
                <div>
                    <h3 class="text-zinc-200 text-xs font-bold tracking-wider uppercase">Active Allocations</h3>
                    <p class="text-zinc-500 text-[9px] uppercase mt-0.5 tracking-wider">Displaying registry database information</p>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="toggleModal('upload-modal')" class="bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 px-4 py-1.5 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                        Upload Series
                    </button>
                    <div class="w-full md:w-72 relative">
                        <input type="text" id="live-search" placeholder="SEARCH..." class="w-full pl-9 pr-4 py-1.5 bg-zinc-950/50 border border-zinc-800 focus:border-emerald-500/50 rounded text-[10px] font-bold text-zinc-200 tracking-wider placeholder-zinc-600 focus:outline-none transition-all uppercase">
                    </div>
                </div>
            </div>

            <div class="w-full overflow-x-auto rounded border border-zinc-900/60 bg-zinc-950/20 max-h-[480px] overflow-y-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="sticky top-0 z-20 bg-[#161d30] shadow-[0_1px_0_0_rgba(24,24,27,1)]">
                        <tr class="bg-zinc-950/80">
                            <th class="px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase">ID</th>
                            <th class="px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase">COC Number</th>
                            <th class="px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Classification</th>
                            <th class="px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Status</th>
                            <th class="px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Timestamp</th>
                            <th class="px-6 py-4 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody id="coc-table-body" class="divide-y divide-zinc-900/40 text-zinc-300">
                        @forelse($cocs as $coc)
                            <tr class="hover:bg-zinc-900/20 transition-colors">
                                <td class="px-6 py-3.5 text-xs font-medium text-zinc-500">{{ $coc->coc_id }}</td>
                                <td class="px-6 py-3.5 text-xs font-bold text-zinc-200 tracking-wide">{{ $coc->coc_no }}</td>
                                <td class="px-6 py-3.5 text-xs font-semibold text-zinc-400">{{ $coc->coc_type }}</td>
                                <td class="px-6 py-3.5 text-xs">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $coc->coc_status === 'Used' ? 'bg-emerald-950/40 text-emerald-400' : 'bg-zinc-900 text-zinc-400' }}">
                                        {{ $coc->coc_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-xs font-medium text-zinc-400">{{ $coc->created_at }}</td>
                                <td class="px-6 py-3.5 text-xs">
                                    <form action="{{ route('coc.destroy', $coc->coc_id) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 font-bold uppercase text-[9px]">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-8 text-center text-xs text-zinc-500 uppercase">No logs found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="pagination-links" class="mt-4">{{ $cocs->links() }}</div>
        </div>
    </div>

    <div id="upload-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-[#161d30] border border-zinc-700 p-6 rounded-lg w-96 shadow-2xl">
            <h2 class="text-white font-bold text-sm uppercase mb-4">Upload New Series</h2>
            <form action="{{ route('coc.store') }}" method="POST">
                @csrf
                <input type="number" name="start_series" placeholder="Start Series (e.g., 1001)" class="w-full p-2 mb-3 bg-zinc-950 border border-zinc-700 rounded text-xs text-white" required>
                <input type="number" name="end_series" placeholder="End Series (e.g., 1050)" class="w-full p-2 mb-3 bg-zinc-950 border border-zinc-700 rounded text-xs text-white" required>
                
                <select name="coc_type" class="w-full p-2 mb-4 bg-zinc-950 border border-zinc-700 rounded text-xs text-white" required>
                    <option value="">Select Classification</option>
                    <option value="MC">MC</option>
                    <option value="TC">TC</option>
                    <option value="PC">PC</option>
                    <option value="CV">CV</option>
                </select>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="toggleModal(false)" class="text-[10px] font-bold text-zinc-500 uppercase">Cancel</button>
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded text-[10px] font-bold uppercase">Save Series</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(show) {
            const modal = document.getElementById('upload-modal');
            // Kunin ang mga container/elements
            const signoutForm = document.getElementById('logout-form'); // Galing sa code mo
            const backBtn = document.querySelector('a[href*="dashboard"]'); 

            if(show) {
                modal.classList.remove('hidden');
                // Itago gamit ang 'hidden' class ng Tailwind
                if(signoutForm) signoutForm.classList.add('hidden');
                if(backBtn) backBtn.classList.add('hidden');
            } else {
                modal.classList.add('hidden');
                // Ibalik sa visible
                if(signoutForm) signoutForm.classList.remove('hidden');
                if(backBtn) backBtn.classList.remove('hidden');
            }
        }
    </script>
@endsection