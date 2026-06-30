@extends('layouts.app') 

@section('navbar_content')
    <div class="no-print" style="display: flex; gap: 10px; align-items: center;">
        <button onclick="printSection('coc-policy-section')" class="btn-print" style="background: #059669;">🖨️ Print COC & Policy</button>
        <button onclick="printSection('invoice-section')" class="btn-print" style="background: #d97706;">🖨️ Print OR</button>
        <button onclick="window.print()" class="btn-print" style="background: #3b82f6;">💾 Save PDF</button>
    </div>
@endsection
@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Return to Main Hub</span>
    </a>
@endsection
@section('content')
<style>
    /* Global Styles para sa Data Positioning */
    .doc-wrapper { position: relative; width: 100%; margin-bottom: 20px; }
    
    .data-text {
        position: absolute;
        font-family: 'Times New Roman', Times, serif;
        font-size: 14px;
        color: #000;
        font-weight: bold;
        pointer-events: none; /* Para hindi ma-highlight ang text habang nag-aadjust */
        white-space: nowrap;
    }

    .centered-text {
        width: 500px; /* I-set ang width na sakop ang linya */
        text-align: center; /* Ito ang nagpapagitna sa bawat linya */
        font-size: 14px;
        white-space: nowrap; /* Sinisiguro na hindi mag-ra-wrap nang kusa ang CSS */
    }

    @media print {
        @page { size: 8.5in 11in; margin: 0.25in; }
        .no-print { display: none !important; }
        
        .print-container { width: 100%; }
        
        /* Siguraduhin ang page breaks */
        .doc-wrapper { page-break-after: always; }
        
        .doc-img-coc { width: 100%; display: block; }
        .doc-img-policy { width: 100%; height: 95vh; object-fit: contain; display: block; }
        .doc-img-invoice { width: 60% !important; margin: 0 auto; display: block; }
        
        .data-text { font-size: 12px; } /* Mas maliit na font sa print para fit */
    }

    /* Screen View */
    .print-container { width: 100%; max-width: 800px; margin: 0 auto; }
    .doc-img-coc { width: 100%; border: 1px solid #ccc; }
    .doc-img-policy { width: 100%; border: 1px solid #ccc; }
    .doc-img-invoice { width: 60%; margin: 0 auto; display: block; border: 1px solid #ccc; }
</style>

<script>
    function printSection(sectionId) {
        const section = document.getElementById(sectionId);
        const style = document.createElement('style');
        style.innerHTML = `@media print { body > *:not(#${sectionId}) { display: none !important; } #${sectionId} { display: block !important; } }`;
        document.head.appendChild(style);
        window.print();
        document.head.removeChild(style);
    }
</script>

<div class="print-container">
    <div class="doc-wrapper">
        <img src="{{ asset('images/coc_mc.png') }}" class="doc-img-coc" alt="COC">
        <div class="data-text" style="top: 110px; left: 628px; font-size: 22px; color: red">{{ $issuance->coc->coc_no }}</div>
        <div class="data-text" style="top: 160px; left: 695px;">{{ $issuance->policy_no }}</div>
        <div class="data-text" style="top: 200px; left: 45px;">{{ $issuance->assured }}</div>
        <div class="data-text" style="top: 235px; left: 45px;">{{ $issuance->address }}</div>

        <div class="data-text" style="top: 228px; left: 515px;">
            {{ \Carbon\Carbon::parse($issuance->created_at)->format('M d, Y') }}
        </div>
        <div class="data-text" style="top: 283px; left: 515px;">
            {{ \Carbon\Carbon::parse($issuance->created_at)->format('M d, Y') }}
        </div>
        <div class="data-text" style="top: 283px; left: 676px;">
            {{ \Carbon\Carbon::parse($issuance->created_at)->addYear()->format('M d, Y') }}
        </div>

        <div class="data-text" style="top: 340px; left: 45px;">{{ $issuance->vehicle->year_model ?? '' }}</div>
        <div class="data-text" style="top: 340px; left: 170px;">{{ $issuance->vehicle->make ?? '' }}</div>
        <div class="data-text" style="top: 340px; left: 335px;">{{ $issuance->vehicle->denomination ?? '' }}</div>
        <div class="data-text" style="top: 340px; left: 495px;">{{ $issuance->vehicle->color ?? '' }}</div>
        <div class="data-text" style="top: 340px; left: 640px;">{{ preg_replace('/^(\d{6})0+(\d+)/', '$1-$2', $issuance->vehicle->file_no) }}</div>

        <div class="data-text" style="top: 370px; left: 45px;">{{ $issuance->vehicle->plate_no ?? '' }}</div>
        <div class="data-text" style="top: 370px; left: 170px;">{{ $issuance->vehicle->chassis_no ?? '' }}</div>
        <div class="data-text" style="top: 370px; left: 335px;">{{ $issuance->vehicle->engine_no ?? '' }}</div>

    </div>

    <div class="doc-wrapper">
        <img src="{{ asset('images/pc_policy.jpg') }}" class="doc-img-policy" alt="Policy">
    </div>
    
    <div class="doc-wrapper" style="text-align: center;">
        <img src="{{ asset('images/invoice.jpg') }}" class="doc-img-invoice" alt="Invoice">
        <div class="data-text" style="top: 153px; left: 465px;">{{ \Carbon\Carbon::parse($issuance->created_at)->format('F d') }}</div>
        <div class="data-text" style="top: 153px; left: 585px;">26</div>
        @php
            $text = $issuance->assured;
            
            $lines = explode("\n", wordwrap($text, 39, "\n", false));
            
            $line1 = $lines[0] ?? '';
            $line2 = $lines[1] ?? '';
            $line3 = $lines[2] ?? '';
        @endphp
        <div class="data-text centered-text" style="top: 173px; left: 205px;">{{ $line1 }}</div>
        <div class="data-text centered-text" style="top: 193px; left: 205px;">{{ $line2 }}</div>
        <div class="data-text centered-text" style="top: 209px; left: 205px;">{{ $line3 }}</div>

        <div class="data-text" style="top: 225px; left: 365px;">{{ $issuance->amount }}</div>
        <div class="data-text" style="top: 225px; left: 535px;">{{ $issuance->vehicle->plate_no ?? '' }}</div>
        <div class="data-text" style="top: 645px; left: 535px; font-size: 18px;">{{ $issuance->amount }}</div>
    </div>
</div>
@endsection