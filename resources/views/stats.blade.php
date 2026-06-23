@extends('layouts.app')

@section('title', 'SYSTEM CORE // STATISTICS_NODE')

@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Dashboard</span>
    </a>
@endsection

@section('content')
    <div class="w-12 h-12 bg-emerald-500/5 border border-emerald-500/20 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(16,185,129,0.05)] mb-5">
        <svg class="w-5 h-5 text-emerald-400/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
    </div>

    <h1 class="text-white text-2xl font-bold tracking-[0.2em] uppercase text-center">
        REMAINING <span class="text-emerald-400">COCs SUMMARY</span>
    </h1>
    <p class="text-zinc-500 text-[10px] font-normal tracking-widest mt-1.5 uppercase text-center">
        real-time certificate tracking allocations by category index points
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full mt-10">
        
        <div class="bg-[#141a29]/60 border border-zinc-900/90 p-5 rounded-sm relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 right-0 h-[1.5px] bg-blue-500/60 shadow-[0_1px_8px_rgba(59,130,246,0.4)]"></div>
            <div class="text-[9px] font-semibold tracking-[0.15em] text-zinc-400 uppercase">MOTORCYCLE (MC)</div>
            <div class="flex flex-col mt-3">
                <span class="text-4xl font-bold text-white tracking-tight">{{ $mcRemaining }}</span>
                <span class="text-[9px] font-bold text-zinc-600 uppercase tracking-widest mt-0.5 font-mono">REMAINING COCS</span>
            </div>
        </div>

        <div class="bg-[#141a29]/60 border border-zinc-900/90 p-5 rounded-sm relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 right-0 h-[1.5px] bg-emerald-500/60 shadow-[0_1px_8px_rgba(16,185,129,0.4)]"></div>
            <div class="text-[9px] font-semibold tracking-[0.15em] text-zinc-400 uppercase">PRIVATE CAR (PC)</div>
            <div class="flex flex-col mt-3">
                <span class="text-4xl font-bold text-white tracking-tight">{{ $pcRemaining }}</span>
                <span class="text-[9px] font-bold text-zinc-600 uppercase tracking-widest mt-0.5 font-mono">REMAINING COCS</span>
            </div>
        </div>

        <div class="bg-[#141a29]/60 border border-zinc-900/90 p-5 rounded-sm relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 right-0 h-[1.5px] bg-amber-500/60 shadow-[0_1px_8px_rgba(245,158,11,0.4)]"></div>
            <div class="text-[9px] font-semibold tracking-[0.15em] text-zinc-400 uppercase">TRICYCLE (TC)</div>
            <div class="flex flex-col mt-3">
                <span class="text-4xl font-bold text-white tracking-tight">{{ $tcRemaining }}</span>
                <span class="text-[9px] font-bold text-zinc-600 uppercase tracking-widest mt-0.5 font-mono">REMAINING COCS</span>
            </div>
        </div>

        <div class="bg-[#141a29]/60 border border-zinc-900/90 p-5 rounded-sm relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 right-0 h-[1.5px] bg-red-500/60 shadow-[0_1px_8px_rgba(239,68,68,0.4)]"></div>
            <div class="text-[9px] font-semibold tracking-[0.15em] text-zinc-400 uppercase">COMMERCIAL (CV)</div>
            <div class="flex flex-col mt-3">
                <span class="text-4xl font-bold text-white tracking-tight">{{ $cvRemaining }}</span>
                <span class="text-[9px] font-bold text-zinc-600 uppercase tracking-widest mt-0.5 font-mono">REMAINING COCS</span>
            </div>
        </div>

    </div>
@endsection