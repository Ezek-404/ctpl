<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTPL Portal - Dashboard Hub</title>
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f172a] min-h-screen font-sans antialiased select-none">

    <!-- Main Content Container -->
    <div class="w-full min-h-screen bg-[#1e293b] flex flex-col items-center justify-center p-6 bg-cover bg-center bg-no-repeat relative selection:bg-emerald-500 selection:text-white"
         style="background-image: linear-gradient(to bottom, rgba(30, 41, 59, 0.92), rgba(15, 23, 42, 0.95)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070');">
        
        <!-- Top-Right Sign Out Layer -->
        <div class="absolute top-6 right-6 z-50">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                @csrf
                <button type="submit" 
                        class="cursor-pointer pointer-events-auto flex items-center gap-2 bg-zinc-950/40 hover:bg-red-950/20 border border-zinc-800 hover:border-red-500/30 px-3 py-1.5 text-[11px] font-bold text-zinc-400 hover:text-red-400 uppercase tracking-wider transition-all duration-200 rounded">
                    <span>Sign Out</span>
                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
        
        <!-- Abstract Tech Mesh Overlays -->
        <div class="absolute inset-0 opacity-5 pointer-events-none overflow-hidden flex items-center justify-center">
            <div class="w-[600px] h-[600px] border border-emerald-500 rounded-full animate-pulse absolute"></div>
            <div class="w-[900px] h-[900px] border border-emerald-400 rounded-full absolute"></div>
        </div>

        <div class="relative z-10 w-full max-w-6xl text-center px-4 flex flex-col items-center">
            
            <!-- Center System Emblem Brand -->
            <div class="mb-6 relative">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-emerald-950 to-emerald-800 border border-emerald-500/40 flex items-center justify-center shadow-2xl relative group">
                    <div class="absolute inset-0 rounded-full bg-emerald-500/10 blur-xl"></div>
                    <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>

            <!-- Dynamic Hub Welcoming Text -->
            <h1 class="text-white text-3xl md:text-5xl font-black tracking-wide uppercase drop-shadow-md">
                WELCOME, <span class="text-emerald-400">ADMINISTRATOR</span>
            </h1>
            <p class="text-zinc-400 text-sm md:text-base font-light tracking-normal mt-2 mb-12">
                What would you like to do today?
            </p>

            <!-- Centered Interactive Grid Links -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 w-full max-w-5xl justify-center pt-4 border-t border-zinc-700/40">
                
                <!-- Item 1: Stats Hub -->
                <a href="{{ route('dashboard.stats') }}" class="group flex flex-col items-center text-center p-4 rounded-xl hover:bg-slate-800/40 border border-transparent hover:border-slate-700/50 transition-all duration-200">
                    <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                    </div>
                    <span class="mt-3 text-[11px] font-bold tracking-wider text-zinc-400 group-hover:text-zinc-200 uppercase">Stats</span>
                </a>

                <!-- Item 2: COC Management -->
                <a href="{{ route('dashboard.coc') }}" class="group flex flex-col items-center text-center p-4 rounded-xl hover:bg-slate-800/40 border border-transparent hover:border-slate-700/50 transition-all duration-200">
                    <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="mt-3 text-[11px] font-bold tracking-wider text-zinc-400 group-hover:text-zinc-200 uppercase">Coc Management</span>
                </a>

                <!-- Item 3: CTPL Issuance -->
                                <a href="#" class="group flex flex-col items-center text-center p-4 rounded-xl hover:bg-slate-800/40 border border-transparent hover:border-slate-700/50 transition-all duration-200">
                    <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <span class="mt-3 text-[11px] font-bold tracking-wider text-zinc-400 group-hover:text-zinc-200 uppercase">CTPL ISSUANCE</span>
                </a>

                <!-- Item 4: Saved Transactions -->
                <a href="#" class="group flex flex-col items-center text-center p-4 rounded-xl hover:bg-slate-800/40 border border-transparent hover:border-slate-700/50 transition-all duration-200">
                    <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="mt-3 text-[11px] font-bold tracking-wider text-zinc-400 group-hover:text-zinc-200 uppercase">Transactions</span>
                </a>

                <!-- Item 5: Comprehensive -->
                <a href="#" class="group flex flex-col items-center text-center p-4 rounded-xl hover:bg-slate-800/40 border border-transparent hover:border-slate-700/50 transition-all duration-200">
                    <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="mt-3 text-[11px] font-bold tracking-wider text-zinc-400 group-hover:text-zinc-200 uppercase">Comprehensive</span>
                </a>

                <!-- Item 6: Profile Account Settings -->
                <a href="{{ route('dashboard.profile') }}" class="group flex flex-col items-center text-center p-4 rounded-xl hover:bg-slate-800/40 border border-transparent hover:border-slate-700/50 transition-all duration-200">
                    <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="mt-3 text-[11px] font-bold tracking-wider text-zinc-400 group-hover:text-zinc-200 uppercase">Profile Info</span>
                </a>

            </div>
        </div>

        <!-- System Label Footer -->
        <div class="absolute bottom-6 text-center w-full text-[9px] tracking-widest uppercase text-zinc-500 font-mono">
            Management Information Division
        </div>
    </div>

</body>
</html>