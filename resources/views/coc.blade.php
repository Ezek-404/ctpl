@extends('layouts.app')

@section('title_part1', 'COC')
@section('title_part2', 'MANAGEMENT')

@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Return to Main Hub</span>
    </a>
@endsection

@section('content')
    <div class="w-full max-w-7xl flex flex-col items-stretch">

        @if (session('success'))
            <div class="mb-4 p-4 bg-emerald-900/20 border border-emerald-500/30 rounded text-emerald-400 text-xs font-bold uppercase tracking-widest text-center">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="w-full bg-[#161d30]/70 border border-zinc-800/80 rounded-lg p-6 shadow-2xl backdrop-blur-sm">
            
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-4 border-b border-zinc-800/60 mb-4">
                <div>
                    <h3 class="text-zinc-200 text-xs font-bold tracking-wider uppercase">Active Allocations</h3>
                    <p class="text-zinc-500 text-[9px] uppercase mt-0.5 tracking-wider">Displaying registry database information</p>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="toggleModal(true)" class="bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 px-4 py-1.5 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                        Upload Series
                    </button>
                    <div class="w-full md:w-72 relative">
                        <input type="text" id="live-search" placeholder="SEARCH..." class="w-full pl-9 pr-4 py-1.5 bg-zinc-950/50 border border-zinc-800 focus:border-emerald-500/50 rounded text-[10px] font-bold text-zinc-200 tracking-wider placeholder-zinc-600 focus:outline-none transition-all uppercase">
                    </div>
                </div>
            </div>

            <div class="w-full overflow-x-auto rounded border border-zinc-900/60 bg-zinc-950/20 max-h-[calc(100vh-280px)] overflow-y-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="sticky top-0 z-20 bg-zinc-950/95 shadow-[0_1px_0_0_rgba(24,24,27,1)]">
                        <tr>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">ID</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">COC Number</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Classification</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Status</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody id="coc-table-body" class="divide-y divide-zinc-900/40 text-zinc-300">
                        @include('partials.coc_table_rows', ['cocs' => $cocs])
                    </tbody>
                </table>
            </div>
            
            <div id="pagination-links" class="mt-4">{{ $cocs->links() }}</div>
        </div>
    </div>

    <div id="upload-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-[#161d30] border border-zinc-700 p-6 rounded-lg w-96 shadow-2xl">
            <h2 class="text-white text-center font-bold text-sm uppercase mb-4">Upload COC Series</h2>
            @if ($errors->any())
                <div class="bg-red-900/30 border border-red-500/50 text-red-400 p-2 mb-4 rounded text-[10px] uppercase font-bold text-center">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('coc.store') }}" method="POST">
                @csrf
                <input type="number" name="start_series" placeholder="Start Series" class="w-full p-2 mb-3 bg-zinc-950 border border-zinc-700 rounded text-xs text-white" required>
                <input type="number" name="end_series" placeholder="End Series" class="w-full p-2 mb-3 bg-zinc-950 border border-zinc-700 rounded text-xs text-white" required>
                
                <select name="coc_type" class="w-full p-2 mb-4 bg-zinc-950 border border-zinc-700 rounded text-xs text-white" required>
                    <option value="">Select Classification</option>
                    <option value="MC">MC</option>
                    <option value="TC">TC</option>
                    <option value="PC">PC</option>
                    <option value="CV">CV</option>
                </select>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="toggleModal(false)" class="text-[10px] font-bold text-zinc-500 uppercase">Cancel</button>
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded text-[10px] font-bold uppercase">Upload Series</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(show) {
            const modal = document.getElementById('upload-modal');
            const nav = document.getElementById('main-navigation'); // Target natin ang nav

            if(show) {
                modal.classList.remove('hidden');
                if(nav) nav.classList.add('opacity-0', 'pointer-events-none'); // Hide navigation
            } else {
                modal.classList.add('hidden');
                if(nav) nav.classList.remove('opacity-0', 'pointer-events-none'); // Show navigation
            }
        }

        document.getElementById('live-search').addEventListener('input', function(e) {
            let query = e.target.value;
            let tableBody = document.getElementById('coc-table-body');

            fetch(`{{ route('cocs.index') }}?search=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => { tableBody.innerHTML = data.html; });
        });

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                toggleModal(true);
            });
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            const successMsg = document.querySelector('.bg-emerald-900\\/20');
            if (successMsg) {
                setTimeout(() => {
                    successMsg.style.transition = 'opacity 0.5s';
                    successMsg.style.opacity = '0';
                    setTimeout(() => successMsg.remove(), 500);
                }, 3000);
            }
        });
    </script>
@endsection