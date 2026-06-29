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
    #btn_issue_policy:disabled {
        opacity: 0.3;          /* Magiging maputla */
        cursor: not-allowed;   /* Magiging "no-entry" icon ang mouse */
        border-color: #52525b; /* Zinc-700 color para mag-blend sa theme */
        color: #a1a1aa;        /* Zinc-400 color para sa text */
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
        <div class="flex items-center justify-between border-b border-zinc-800/60 pb-4 mb-8">
            @php
                $container = "bg-zinc-900/50 rounded border border-zinc-800 overflow-hidden items-center flex";
                $label = "bg-zinc-800/60 px-4 py-2 text-[9px] font-black text-zinc-300 uppercase tracking-widest border-r border-zinc-800 w-[120px] shrink-0";
                $input = "bg-transparent px-4 py-2 text-[11px] text-white uppercase focus:outline-none w-full tracking-wider";
            @endphp
            
            <div class="grid grid-cols-12 gap-x-4 mb-6">
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Search By</label>
                    <select id="search_type" class="{{ $input }} appearance-none cursor-pointer">
                        <option value="plate_no">Plate Number</option>
                        <option value="file_no">MV File No.</option>
                        <option value="engine_no">Engine Number</option>
                        <option value="chassis_no">Chassis Number</option>
                    </select>
                </div>
                <div class="col-span-7 {{ $container }}">
                    <input type="text" id="search_input" class="{{ $input }}" placeholder="ENTER VALUE TO SEARCH...">
                </div>
                <div class="col-span-2">
                    <button id="btn_search" class="w-full h-full bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 font-bold uppercase text-[10px] tracking-widest hover:bg-emerald-600/30 rounded">
                        Search
                    </button>
                </div>
            </div>
        </div>
        
        <form id="issuanceForm" action="{{ route('ctpl.store') }}" method="POST">
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
                    <input type="text" name="assured" id="assured" class="{{ $input }}" required>
                </div>
                <div class="col-span-6 {{ $container }}">
                    <label class="{{ $label }}">Address</label>
                    <input type="text" name="address" id="address" class="{{ $input }}" required>
                </div>

                {{-- Row 2: 4 Fields (3 + 3 + 3 + 3) --}}
                {{-- Year Model: Changed to type="number" --}}
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Year Model</label>
                    <input type="number" name="year_model" id="year_model" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Make</label>
                    <input type="text" name="make" id="make" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Series</label>
                    <input type="text" name="series" id="series" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Color</label>
                    <input type="text" name="color" id="color" class="{{ $input }}" required>
                </div>

               {{-- Row 3: MV, Plate, Engine, Chassis --}}
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">MV File No.</label>
                    <input type="text" name="file_no" id="file_no" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Plate No.</label>
                    <input type="text" name="plate_no" id="plate_no" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Engine No.</label>
                    <input type="text" name="engine_no" id="engine_no" class="{{ $input }}" required>
                </div>
                <div class="col-span-3 {{ $container }}">
                    <label class="{{ $label }}">Chassis No.</label>
                    <input type="text" name="chassis_no" id="chassis_no" class="{{ $input }}" required>
                </div>

                {{-- Row 4: 4 Fields (3 + 3 + 3 + 3) --}}
                <div class="col-span-4 {{ $container }} relative">
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
                <div class="col-span-4 {{ $container }} relative">
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
                <div class="col-span-4 {{ $container }}">
                    <label class="{{ $label }}">Policy No.</label>
                    <input type="number" name="policy_number" id="policy_number" 
                    class="{{ $input }} disabled:opacity-30 disabled:cursor-not-allowed" 
                    placeholder="SELECT DENOMINATION FIRST" disabled required>
                </div>
                <div class="col-span-6 {{ $container }}">
                    <label class="{{ $label }}">Agent</label>
                    <input type="text" name="agent" class="{{ $input }}" required>
                </div>
                <div class="col-span-6 {{ $container }}">
                    <label class="{{ $label }}">Amount</label>
                    <input type="text" name="amount" class="{{ $input }}" required>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" id="btn_issue_policy" disabled class="bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 px-8 py-3 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
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
    const amountInput = document.getElementById('amount'); // Siguraduhing may id="amount"
    const iconLoading = document.getElementById('icon_loading');
    const iconError = document.getElementById('icon_error');
    const iconSuccess = document.getElementById('icon_success');
    const btnIssue = document.getElementById('btn_issue_policy');
    const issuanceForm = document.getElementById('issuanceForm');
    const searchInput = document.getElementById('search_input');
    const btnSearch = document.getElementById('btn_search');
    const assuredInput = document.getElementById('assured');

    let debounceTimer;

    // Rules para sa Amount per Denomination
    const getAmountRange = (denom) => {
        const rules = {
            'MC': { min: 550, max: 650 },
            'PC': { min: 950, max: 1250 },
            'TC': { min: 550, max: 550 },
            'CV': { min: 1500, max: 2000 }
        };
        return rules[denom] || null;
    };

    const setFieldValue = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.value = value || '';
    };

    const validateAmount = () => {
        if (!amountInput || !denomSelect.value) return true;
        const range = getAmountRange(denomSelect.value);
        if (!range) return true;
        
        const val = parseFloat(amountInput.value);
        const isValid = !isNaN(val) && val >= range.min && val <= range.max;
        
        amountInput.style.borderColor = isValid ? "" : "red";
        return isValid;
    };

    const validateForm = () => {
        if (!btnIssue) return;
        const requiredInputs = document.querySelectorAll('input[required], select[required]');
        let allFilled = Array.from(requiredInputs).every(i => i.value.trim() !== '' && !i.disabled);

        const isCocValid = iconSuccess && !iconSuccess.classList.contains('hidden');
        const isAmountValid = validateAmount();
        
        const isFormValid = allFilled && isCocValid && isAmountValid;
        
        btnIssue.disabled = !isFormValid;
        btnIssue.style.opacity = isFormValid ? "1" : "0.3";
        btnIssue.style.cursor = isFormValid ? "pointer" : "not-allowed";
    };

    // 1. Reset logic + Placeholder update
    denomSelect?.addEventListener('change', function() {
        if (cocInput) cocInput.value = '';
        if (policyInput) policyInput.value = '';
        if (amountInput) amountInput.value = '';
        [iconLoading, iconError, iconSuccess].forEach(i => i?.classList.add('hidden'));

        const isDisabled = this.value === "";
        
        if (cocInput) {
            cocInput.disabled = isDisabled;
            cocInput.placeholder = isDisabled ? "Select Denomination First" : "Enter COC No.";
        }
        if (policyInput) {
            policyInput.disabled = isDisabled;
            policyInput.placeholder = isDisabled ? "Select Denomination First" : "Enter Policy No.";
        }
        
        if (!isDisabled) {
            setTimeout(() => cocInput?.focus(), 100);
        }
        
        validateForm();
    });

    // 2. AJAX Check COC
    cocInput?.addEventListener('input', function() {
        const val = this.value;
        const denom = denomSelect?.value;
        
        clearTimeout(debounceTimer);
        [iconError, iconSuccess].forEach(i => i?.classList.add('hidden'));

        if (val.length < 3) {
            iconLoading?.classList.add('hidden');
            validateForm();
            return;
        }

        iconLoading?.classList.remove('hidden');

        debounceTimer = setTimeout(async () => {
            try {
                const response = await fetch(`{{ route('ctpl.check-coc') }}?coc_number=${val}&denomination=${denom}`);
                const data = await response.json();

                iconLoading?.classList.remove('hidden');
                if (data.available) {
                    iconSuccess?.classList.remove('hidden');
                    policyInput?.focus();
                } else {
                    iconError?.classList.remove('hidden');
                }
                validateForm();
            } catch (error) {
                iconLoading?.classList.remove('hidden');
                iconError?.classList.remove('hidden');
                validateForm();
            }
        }, 500);
    });

    // 3. Search Function
    async function performSearch() {
        const type = document.getElementById('search_type')?.value; 
        const value = searchInput?.value;

        if (!value) return alert("Please enter a value to search.");

        try {
            const response = await fetch(`{{ route('ctpl.get-vehicle-details') }}?type=${type}&value=${value}`);
            const data = await response.json();

            if (data.success) {
                const v = data.data;
                Object.keys(v).forEach(key => setFieldValue(key, v[key]));
                
                denomSelect?.dispatchEvent(new Event('change'));
                validateForm();
                
                // Smart Focus Logic: Lipat sa assured, o diretso sa COC kung puno na ang assured
                setTimeout(() => {
                    if (assuredInput && assuredInput.value.trim() !== "") {
                        cocInput?.focus();
                    } else if (assuredInput) {
                        assuredInput.focus();
                    } else {
                        denomSelect?.focus();
                    }
                }, 150);

            } else {
                alert("No record found.");
            }
        } catch (error) {
            alert("An error occurred while searching.");
        }
    }

    // 4. Submit with AJAX
    btnIssue?.addEventListener('click', async (e) => {
        e.preventDefault(); 
        btnIssue.disabled = true;
        btnIssue.innerText = "Processing...";

        const formData = new FormData(issuanceForm);

        try {
            const response = await fetch('{{ route("ctpl.store") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            const result = await response.json();

            if (result.success) {
                const id = result.data?.transaction_id;
                if (id) {
                    window.location.href = `/ctpl/print/${id}`;
                } else {
                    alert("Transaction successful, pero hindi mahanap ang transaction_id.");
                    btnIssue.disabled = false;
                    btnIssue.innerText = "Issue Policy";
                }
            } else {
                alert("Error: " + (result.message || "Failed to process."));
                btnIssue.disabled = false;
                btnIssue.innerText = "Issue Policy";
            }
        } catch (error) {
            alert("System error occurred.");
            btnIssue.disabled = false;
            btnIssue.innerText = "Issue Policy";
        }
    });

    // Event Listeners para sa lahat ng inputs
    document.querySelectorAll('input, select').forEach(el => {
        el.addEventListener('input', validateForm);
        el.addEventListener('change', validateForm);
    });

    btnSearch?.addEventListener('click', performSearch);

    // Enter key para sa Search
    searchInput?.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });
</script>
@endsection

