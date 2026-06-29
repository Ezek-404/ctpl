<style>
    .page-container { position: relative; width: 800px; margin: auto; }
    .doc-img { width: 100%; display: block; margin-bottom: 20px; }
    .data { position: absolute; font-size: 12px; font-family: Arial; }
    @media print { .no-print { display: none; } }
</style>

<div class="page-container">
    <div style="position: relative;">
        <img src="{{ asset('images/coc_pc.png') }}" class="doc-img">
        <div class="data" style="top: 150px; left: 100px;">{{ $issuance->assured }}</div>
        <div class="data" style="top: 150px; left: 500px;">{{ $issuance->vehicle->plate_no }}</div>
    </div>

    <div style="position: relative;">
        <img src="{{ asset('images/pc_policy.jpg') }}" class="doc-img">
        <div class="data" style="top: 100px; left: 100px;">{{ $issuance->assured }}</div>
    </div>

    <div style="position: relative;">
        <img src="{{ asset('images/invoice.jpg') }}" class="doc-img">
        <div class="data" style="top: 200px; left: 100px;">{{ $issuance->amount }}</div>
    </div>

    <button class="no-print" onclick="window.print()">PRINT ALL</button>
</div>