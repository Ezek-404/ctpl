@extends('layouts.app')

@section('title_part1', 'CTPL')
@section('title_part2', 'ISSUANCE')

@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Return to Main Hub</span>
    </a>
@endsection

@section('content')
    <div class="w-full max-w-5xl flex flex-col items-stretch">
        
        @if (session('success'))
            <div class="mb-4 p-4 bg-emerald-900/20 border border-emerald-500/30 rounded text-emerald-400 text-xs font-bold uppercase tracking-widest text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="w-full bg-[#161d30]/70 border border-zinc-800/80 rounded-lg p-8 shadow-2xl backdrop-blur-sm">
            <h3 class="text-zinc-200 text-xs font-bold tracking-wider uppercase mb-6 border-b border-zinc-800/60 pb-4">
                CTPL Issuance Registration Form
            </h3>

            <form action="{{ route('ctpl.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <input type="text" name="assured_name" placeholder="ASSURED NAME" class="w-full p-2 bg-zinc-950/50 border border-zinc-700 rounded text-xs text-white uppercase placeholder-zinc-600 focus:border-emerald-500/50 transition-all outline-none" required>
                        <input type="text" name="address" placeholder="ADDRESS" class="w-full p-2 bg-zinc-950/50 border border-zinc-700 rounded text-xs text-white uppercase placeholder-zinc-600 focus:border-emerald-500/50 transition-all outline-none" required>
                        </div>

                    <div class="space-y-4">
                         <select name="denomination" class="w-full p-2 bg-zinc-950/50 border border-zinc-700 rounded text-xs text-white uppercase focus:border-emerald-500/50 transition-all outline-none">
                            <option value="">SELECT DENOMINATION</option>
                            <option value="MC">MOTORCYCLE - MC</option>
                            </select>
                        <input type="number" name="amount" placeholder="AMOUNT" class="w-full p-2 bg-zinc-950/50 border border-zinc-700 rounded text-xs text-white uppercase placeholder-zinc-600 focus:border-emerald-500/50 transition-all outline-none">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 px-8 py-2.5 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                        Issue Policy
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection