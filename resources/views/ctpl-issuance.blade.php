@extends('layouts.app')
<style>
    /* Alisin ang arrows sa number inputs */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield; /* Para sa Firefox */
    }
    /* Siguraduhin na ang select element ay sumusunod sa theme */
    select {
        background-color: transparent !important;
    }

    /* Para sa Chrome/Edge/Firefox dropdown options */
    option {
        background-color: #18181b; /* color ng zinc-900 */
        color: #ffffff;
    }
</style>
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
<div class="w-full max-w-7xl mx-auto p-6">
    <div class="bg-[#161d30]/70 border border-zinc-800/80 rounded-lg p-8 shadow-2xl backdrop-blur-sm">
        <h1 class="text-white text-sm font-black uppercase tracking-widest mb-8 border-b border-zinc-800/60 pb-4">CTPL Issuance Form</h1>
        
        <form action="{{ route('ctpl.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-12 gap-x-4 gap-y-3">
                
                @php
                    $container = "bg-zinc-900/50 rounded border border-zinc-800 overflow-hidden items-center flex";
                    $label = "bg-zinc-800/60 px-4 py-2 text-[9px] font-black text-zinc-300 uppercase tracking-widest border-r border-zinc-800 w-[120px] shrink-0";
                    $input = "bg-transparent px-4 py-2 text-[11px] text-white uppercase focus:outline-none w-full tracking-wider";
                @endphp

                {{-- Row 1: 2 Fields (6 + 6) --}}
                <div class="col-span-6 {{ $container }}">
                    <label class="{{ $label }}">Assured</label>
                    <input type="text" name="assured_name" class="{{ $input }}" required>
                </div>
                <div class="col-span-6 {{ $container }}">
                    <label class="{{ $label }}">Address</label>
                    <input type="text" name="address" class="{{ $input }}" required>
                </div>

                {{-- Row 2: 4 Fields (3 + 3 + 3 + 3) --}}
                {{-- Year Model: Changed to type="number" --}}
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Year Model</label>
                    <input type="number" name="year_model" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Make</label>
                    <input type="text" name="make" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Series</label>
                    <input type="text" name="series" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Color</label>
                    <input type="text" name="color" class="{{ $input }}" required>
                </div>

                {{-- Row 3: 4 Fields (3 + 3 + 3 + 3) --}}
                @foreach(['mv_file'=>'MV File No.', 'plate_number'=>'Plate No.', 'engine_number'=>'Engine No.', 'chassis_number'=>'Chassis No.'] as $n => $l)
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">{{ $l }}</label>
                    <input type="text" name="{{ $n }}" class="{{ $input }}" required>
                </div>
                @endforeach

                {{-- Row 4: 4 Fields (3 + 3 + 3 + 3) --}}
                <div class="col-span-6 {{ $container }} relative">
                    <label class="{{ $label }}">Denomination</label>
                    <select name="denomination" id="denomination" class="{{ $input }} appearance-none cursor-pointer" required>
                        <option value="" disabled selected>-- Select DENOMINATION --</option>
                        <optgroup label="Motorcycle" class="bg-zinc-800 text-white">
                            <option value="MC" class="bg-zinc-900">MC</option>
                            <option value="MTC" class="bg-zinc-900">MTC</option>
                        </optgroup>
                        
                        <optgroup label="Private Car" class="bg-zinc-800 text-white">
                            <option value="CAR" class="bg-zinc-900">CAR</option>
                            <option value="PASSENGER CAR" class="bg-zinc-900">PASSENGER CAR</option>
                            <option value="SEDAN" class="bg-zinc-900">SEDAN</option>
                            <option value="HATCHBACK" class="bg-zinc-900">HATCHBACK</option>
                            <option value="UTILITY VEHICLE" class="bg-zinc-900">UTILITY VEHICLE</option>
                            <option value="SUV" class="bg-zinc-900">SUV</option>
                            <option value="COUPE" class="bg-zinc-900">COUPE</option>
                        </optgroup>
                        
                        <optgroup label="Tricycle" class="bg-zinc-800 text-white">
                            <option value="TRICYCLE" class="bg-zinc-900">TRICYCLE</option>
                        </optgroup>
                        
                        <optgroup label="Commercial Vehicle" class="bg-zinc-800 text-white">
                            <option value="TRUCK" class="bg-zinc-900">TRUCK</option>
                            <option value="TRAILER" class="bg-zinc-900">TRAILER</option>
                        </optgroup>
                    </select>
                    
                    {{-- Custom Arrow Icon para maging match sa theme --}}
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                        <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
                <div class="col-span-6 {{ $container }} relative">
                    <label class="{{ $label }}">COC No.</label>
                    <input type="number" name="coc_number" id="coc_number" 
                        class="{{ $input }} pr-10 disabled:opacity-30 disabled:cursor-not-allowed" 
                        placeholder="SELECT DENOMINATION FIRST" disabled required>
                    
                    <div id="coc_status" class="absolute right-3 top-2 flex items-center pointer-events-none">
                        <span id="icon_loading" class="hidden text-zinc-500 animate-spin">⏳</span>
                        <span id="icon_error" class="hidden text-red-500">❌</span>
                        <span id="icon_success" class="hidden text-emerald-500">✅</span>
                    </div>
                </div>
                <div class="col-span-6 {{ $container }}">
                    <label class="{{ $label }}">Policy No.</label>
                    <input type="number" name="policy_number" id="policy_number" 
                    class="{{ $input }} disabled:opacity-30 disabled:cursor-not-allowed" 
                    placeholder="SELECT DENOMINATION FIRST" disabled required>
                </div>
                <div class="col-span-6 {{ $container }}">
                    <label class="{{ $label }}">Agent</label>
                    <input type="text" name="agent" class="{{ $input }}" required>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 px-8 py-3 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                    Issue Policy
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    const denomSelect = document.getElementById('denomination');
    const cocInput = document.getElementById('coc_number');
    const policyInput = document.getElementById('policy_number');
    const iconLoading = document.getElementById('icon_loading');
    const iconError = document.getElementById('icon_error');
    const iconSuccess = document.getElementById('icon_success');

    // Variable para sa debounce timer
    let debounceTimer;

    // 1. Enable/Disable at Reset logic
    denomSelect.addEventListener('change', function() {
        // I-clear ang values ng inputs tuwing nagpapalit ng denom
        cocInput.value = '';
        policyInput.value = '';

        // Itago lahat ng icons
        iconLoading.classList.add('hidden');
        iconError.classList.add('hidden');
        iconSuccess.classList.add('hidden');

        // I-reset ang timer kung sakaling may active pa
        clearTimeout(debounceTimer);

        if (this.value !== "") {
            cocInput.disabled = false;
            policyInput.disabled = false;
            cocInput.placeholder = "ENTER COC NO.";
            policyInput.placeholder = "ENTER POLICY NO.";
        } else {
            cocInput.disabled = true;
            policyInput.disabled = true;
            cocInput.placeholder = "SELECT DENOM FIRST";
            policyInput.placeholder = "SELECT DENOM FIRST";
        }
    });

    // 2. AJAX Check logic na may 1-second delay (Debouncing)
    cocInput.addEventListener('input', function() {
        const val = this.value;
        const denom = denomSelect.value;
        
        // Linisin ang lumang timer tuwing may bagong input
        clearTimeout(debounceTimer);

        if (val.length < 3) {
            iconLoading.classList.add('hidden');
            iconError.classList.add('hidden');
            iconSuccess.classList.add('hidden');
            return;
        }

        // Ipakita ang loading icon agad habang naghihintay ng 1 second
        iconLoading.classList.remove('hidden');
        iconError.classList.add('hidden');
        iconSuccess.classList.add('hidden');

        // Mag-set ng bagong 1-second delay bago mag-fetch
        debounceTimer = setTimeout(async () => {
            try {
                const response = await fetch(`{{ route('ctpl.check-coc') }}?coc_number=${val}&denomination=${denom}`);
                const data = await response.json();

                iconLoading.classList.add('hidden');
                
                if (data.available) {
                    iconSuccess.classList.remove('hidden');
                    iconError.classList.add('hidden');
                } else {
                    iconSuccess.classList.add('hidden');
                    iconError.classList.remove('hidden');
                }
            } catch (error) {
                iconLoading.classList.add('hidden');
                iconError.classList.remove('hidden');
            }
        }, 800); // 1000ms = 1 second delay
    });
</script>
@endsection

