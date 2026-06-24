<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LTO CORE NODE')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif']
                    }
                }
            }
        }
    </script>

</head>
<body class="w-full min-h-screen bg-[#111625] text-zinc-300 font-sans antialiased select-none overflow-x-hidden relative flex flex-col items-center p-6 selection:bg-emerald-500 selection:text-white"
      style="background-image: linear-gradient(to bottom, rgba(30, 41, 59, 0.92), rgba(15, 23, 42, 0.95)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <div id="main-navigation" class="absolute top-6 left-6 right-6 z-50 grid grid-cols-3 items-center pointer-events-none">
        
        <div class="pointer-events-auto justify-self-start">
            @yield('back_button')
        </div>

        <div class="pointer-events-auto justify-self-center">
            <h1 class="font-black text-lg uppercase tracking-[0.2em] flex gap-2">
                <span class="text-white">@yield('title_part1', 'ALPHA')</span>
                <span class="text-[#34d399]">@yield('title_part2', 'CTPL')</span>
            </h1>
        </div>

        <div class="pointer-events-auto justify-self-end">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                @csrf
                <button type="submit" 
                        class="cursor-pointer flex items-center gap-2 bg-zinc-950/40 hover:bg-red-950/20 border border-zinc-800 hover:border-red-500/30 px-3 py-1.5 text-[11px] font-bold text-zinc-400 hover:text-red-400 uppercase tracking-wider transition-all duration-200 rounded">
                    <span>Sign Out</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <main class="w-full max-w-7xl flex flex-col items-center mt-20 relative z-10">
        @yield('content')
    </main>

    <div class="absolute bottom-6 text-center w-full text-[10px] tracking-widest uppercase text-zinc-500">
        Management Information Division
    </div>

</body>
</html>
