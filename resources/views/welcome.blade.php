<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTPL Portal - Login</title>
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-full bg-[#0a0a0a] flex items-center justify-center font-sans selection:bg-emerald-500 selection:text-white antialiased">

    <!-- Main Container Layout (Mimicking {D2C1E3E4-E584-4B08-AC07-FD5742121D87}.png) -->
    <div class="w-full max-w-4xl mx-4 bg-[#111111] border border-zinc-800/80 rounded-lg overflow-hidden grid grid-cols-1 md:grid-cols-2 shadow-2xl min-h-[500px]">
        
        <!-- Left Column: Form Section -->
        <div class="p-8 lg:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <h2 class="text-white text-lg font-semibold tracking-wide uppercase">Let's get started</h2>
                <p class="text-zinc-400 text-xs mt-1">Provide your credentials below to access the CTPL Management System.</p>
            </div>

            <!-- Login Form (Structure from {943F79B4-C798-4B4B-A3C7-E6A0B0028AA0}.jpg) -->
            <form action="/" method="POST" class="space-y-4">
                @csrf
                <!-- Account / Username -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-500"></span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address (e.g., e1@mail.com)" required
                        class="w-full pl-9 pr-4 py-2 bg-[#18181b] border border-zinc-800 text-zinc-200 text-xs rounded focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder-zinc-600">
                </div>

                <!-- Password -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <!-- 2. Added name="password" here -->
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full pl-9 pr-4 py-2 bg-[#18181b] border border-zinc-800 text-zinc-200 text-xs rounded focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder-zinc-600">
                </div>

                <!-- Utilities Row -->
                <div class="flex items-center justify-between text-[11px] pt-1">
                    <label class="flex items-center text-zinc-400 cursor-pointer select-none">
                        <input type="checkbox" class="rounded bg-[#18181b] border-zinc-800 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 mr-1.5 w-3.5 h-3.5"> 
                        Remember Username
                    </label>
                    <a href="#" class="text-zinc-500 hover:text-emerald-400 transition-colors">Forgot Password?</a>
                </div>

                <!-- Action Button -->
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-white hover:bg-zinc-200 text-black font-semibold py-2 px-4 rounded text-xs transition-colors tracking-wide uppercase shadow-md">
                        Sign In
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column: Re-themed Tech/Logo Branding Panel -->
        <div class="hidden md:flex relative bg-[#141414] border-l border-zinc-800/80 items-center justify-center p-8 bg-cover bg-center"
             style="background-image: linear-gradient(to bottom, rgba(10, 10, 10, 0.85), rgba(4, 47, 31, 0.85)), url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1964');">
            
            <!-- Abstract wireframe accent container -->
            <div class="absolute inset-0 opacity-10 flex items-center justify-center overflow-hidden pointer-events-none">
                <div class="w-[300px] h-[300px] border border-emerald-500 rounded-full animate-pulse"></div>
                <div class="w-[500px] h-[500px] border border-emerald-500 rounded-full absolute"></div>
            </div>

            <!-- New Corporate Green Logo Badge Placement -->
            <div class="relative z-10 text-center flex flex-col items-center">
                <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-emerald-950 to-emerald-800 border-2 border-emerald-500/50 flex items-center justify-center shadow-2xl mb-4 relative group">
                    <div class="absolute inset-0 rounded-full bg-emerald-500/10 blur-xl group-hover:bg-emerald-500/20 transition-all"></div>
                    <!-- Put your real img here: <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 object-contain" /> -->
                    <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold tracking-tighter text-white uppercase drop-shadow-md">
                    CTPL<span class="text-emerald-500">.</span>
                </h1>
                <p class="text-zinc-500 text-[11px] uppercase tracking-widest mt-1 font-medium">System Portal</p>
            </div>

            <!-- Subtle footer info label inside the card view -->
            <div class="absolute bottom-4 text-center w-full text-[9px] tracking-widest uppercase text-zinc-600 font-mono">
                Management Information Division
            </div>
        </div>
    </div>

</body>
</html>