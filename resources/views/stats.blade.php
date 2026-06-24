@extends('layouts.app')

@section('title_part1', 'DASHBOARD')
@section('title_part2', 'SUMMARY')

@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Dashboard</span>
    </a>
@endsection

@section('content')
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