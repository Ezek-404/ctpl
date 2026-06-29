@extends('layouts.app') 

@section('navbar_content')
    <div class="no-print" style="display: flex; gap: 10px; align-items: center;">
        <button onclick="printSection('main-print-section')" class="btn-print" style="background: #3b82f6;">🖨️ PRINT ALL</button>
    </div>
@endsection

@section('content')
<style>
    /* Global Styles para sa Data Positioning */
    .doc-wrapper { position: relative; width: 100%; margin-bottom: 20px; }
    
    .data-text {
        position: absolute;
        font-family: 'Times New Roman', Times, serif;
        font-size: 16px;
        color: #000;
        font-weight: bold;
        pointer-events: none; /* Para hindi ma-highlight ang text habang nag-aadjust */
        white-space: nowrap;
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
        <img src="{{ asset('images/coc_pc.png') }}" class="doc-img-coc" alt="COC">
        <div class="data-text" style="top: 160px; left: 695px;">{{ $issuance->policy_no }}</div>
        <div class="data-text" style="top: 200px; left: 45px;">{{ $issuance->assured }}</div>
        <div class="data-text" style="top: 235px; left: 45px; width: 400px;">{{ $issuance->address }}</div>

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
        <div class="data-text" style="top: 340px; left: 640px;">{{ $issuance->vehicle->file_no ?? '' }}</div>

        <div class="data-text" style="top: 370px; left: 45px;">{{ $issuance->vehicle->plate_no ?? '' }}</div>
        <div class="data-text" style="top: 370px; left: 170px;">{{ $issuance->vehicle->chassis_no ?? '' }}</div>
        <div class="data-text" style="top: 370px; left: 370px;">{{ $issuance->vehicle->engine_no ?? '' }}</div>

    </div>

    <div class="doc-wrapper">
        <img src="{{ asset('images/pc_policy.jpg') }}" class="doc-img-policy" alt="Policy">
    </div>
    
    <div class="doc-wrapper" style="text-align: center;">
        <img src="{{ asset('images/invoice.jpg') }}" class="doc-img-invoice" alt="Invoice">
    </div>
</div>
@endsection