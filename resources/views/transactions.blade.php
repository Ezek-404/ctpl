@extends('layouts.app')

@section('title_part1', 'TRANSACTION')
@section('title_part2', 'LOGS')

@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Dashboard</span>
    </a>
@endsection

@section('content')
    <div class="w-full max-w-7xl flex flex-col items-stretch h-[calc(100vh-150px)]">
        
        <div class="w-full bg-[#161d30]/70 border border-zinc-800/80 rounded-lg p-6 shadow-2xl backdrop-blur-sm flex flex-col flex-grow overflow-hidden">
            
            <div class="flex-shrink-0 flex items-center justify-between pb-4 border-b border-zinc-800/60 mb-4">
                <div>
                    <h3 class="text-zinc-200 text-xs font-bold tracking-wider uppercase">Transaction History</h3>
                    <p class="text-zinc-500 text-[9px] uppercase mt-0.5 tracking-wider">Viewing all issued policies</p>
                </div>
                
                <div class="w-72 relative">
                    <input type="text" id="tx-search" placeholder="SEARCH TRANSACTIONS..." class="w-full pl-9 pr-4 py-1.5 bg-zinc-950/50 border border-zinc-800 focus:border-emerald-500/50 rounded text-[10px] font-bold text-zinc-200 tracking-wider placeholder-zinc-600 focus:outline-none transition-all uppercase">
                </div>
            </div>

            <div class="flex-grow overflow-y-auto custom-scrollbar rounded border border-zinc-900/60 bg-zinc-950/20">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="sticky top-0 z-20 bg-zinc-950/95 shadow-[0_1px_0_0_rgba(24,24,27,1)]">
                        <tr>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">TX ID</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Assured Name</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Plate No.</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">COC No.</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase">Date Issued</th>
                            <th class="px-6 py-3 text-[10px] font-black tracking-widest text-zinc-400 uppercase text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tx-table-body" class="divide-y divide-zinc-900/40 text-zinc-300">
                        @include('partials.transactions_table')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.history.replaceState(null, null, window.location.href);

            const searchInput = document.getElementById('tx-search');
            const tableBody = document.getElementById('tx-table-body');
            let debounceTimer;

            // Fetch dynamic records via AJAX
            function fetchTransactions(page = 1, searchQuery = '') {
                const url = `{{ route('dashboard.transactions') }}?page=${page}&search=${encodeURIComponent(searchQuery)}`;
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tableBody.innerHTML = html;
                })
                .catch(error => console.error('Error loading transaction data:', error));
            }

            // Real-time search with a 300ms debounce to prevent database spamming
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value;
                debounceTimer = setTimeout(() => {
                    fetchTransactions(1, query);
                }, 300);
            });

            // Handle Pagination Link clicks dynamically
            tableBody.addEventListener('click', function(e) {
                const anchor = e.target.closest('.custom-pagination a');
                if (anchor) {
                    e.preventDefault();
                    const urlParams = new URLSearchParams(new URL(anchor.href).search);
                    const page = urlParams.get('page') || 1;
                    const query = searchInput.value;
                    fetchTransactions(page, query);
                }
            });
        });
    </script>
@endsection