@extends('layouts.app')

@section('title_part1', 'PROFILE')
@section('title_part2', 'INFO')

@section('back_button')
    <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-colors duration-150 text-[11px] font-bold uppercase tracking-widest">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Return to Main Hub</span>
    </a>
@endsection

@section('content')
    <div class="w-full max-w-3xl flex flex-col items-stretch">
        @if (session('success'))
            <div class="mb-4 p-4 bg-emerald-900/20 border border-emerald-500/30 rounded text-emerald-400 text-xs font-bold uppercase tracking-widest text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#161d30]/70 border border-zinc-800/80 rounded-lg p-8 shadow-2xl backdrop-blur-sm">
            <div class="flex items-center gap-6 mb-8 border-b border-zinc-800/60 pb-8">
                <div class="w-20 h-20 rounded-full bg-emerald-500/10 border-2 border-emerald-500/20 flex items-center justify-center">
                    <span class="text-2xl font-black text-emerald-400">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-white font-bold text-xl uppercase">{{ $user->name }}</h2>
                    <p class="text-zinc-500 text-xs uppercase tracking-widest">{{ $user->email }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest">Address</label>
                        <p class="text-white text-sm uppercase font-medium mt-1">{{ $user->address ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest">Contact Number</label>
                        <p class="text-white text-sm font-medium mt-1">{{ $user->cp_no ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest">TIN</label>
                        <p class="text-white text-sm font-medium mt-1">{{ $user->tin ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-zinc-800/60">
                    <h3 class="text-white font-bold text-xs uppercase mb-4">Government Records</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach(['SSS' => $user->sss, 'Pag-IBIG' => $user->pagibig, 'PhilHealth' => $user->philhealth, 'LTO ID' => $user->lto_id] as $label => $value)
                            <div>
                                <label class="text-[9px] text-zinc-500 font-bold uppercase">{{ $label }}</label>
                                <p class="text-white text-sm mt-1">{{ $value ?? 'N/A' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 border-t border-zinc-800/60">
                    <button type="button" onclick="toggleEditModal(true)" class="bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 px-6 py-2 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-profile-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-[#161d30] border border-zinc-700 p-6 rounded-lg w-96 shadow-2xl max-h-[80vh] overflow-y-auto">
            <h2 class="text-white font-bold text-sm uppercase mb-4">Edit Profile</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-3">
                    <div><label class="text-[9px] text-zinc-500 font-bold uppercase">Email</label><input type="email" name="email" value="{{ $user->email }}" class="w-full p-2 bg-zinc-950 border border-zinc-700 rounded text-xs text-white" required></div>
                    <div><label class="text-[9px] text-zinc-500 font-bold uppercase">New Password</label><input type="password" name="password" class="w-full p-2 bg-zinc-950 border border-zinc-700 rounded text-xs text-white"></div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleEditModal(false)" class="text-[10px] font-bold text-zinc-500 uppercase">Cancel</button>
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded text-[10px] font-bold uppercase">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleEditModal(show) {
            const modal = document.getElementById('edit-profile-modal');
            const nav = document.getElementById('main-navigation'); // Target natin ang nav

            if(show) {
                modal.classList.remove('hidden');
                if(nav) nav.classList.add('opacity-0', 'pointer-events-none'); // Hide navigation
            } else {
                modal.classList.add('hidden');
                if(nav) nav.classList.remove('opacity-0', 'pointer-events-none'); // Show navigation
            }
        }
    </script>
@endsection