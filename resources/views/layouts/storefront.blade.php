<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop') — MA Hospitality & Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
    </style>
</head>
<body class="bg-[#f5f5f0] text-[#1F2937] antialiased">
    @php
        $cartCount = collect(session('cart', []))->sum();
    @endphp

    <header class="bg-[#111318] text-white sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 md:px-8">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('storefront.home') }}" class="flex flex-col leading-tight">
                    <span class="text-[10px] tracking-[0.28em] text-[#F6C76E] uppercase">MA Hospitality</span>
                    <span class="font-extrabold text-lg -mt-0.5">&amp; Mart</span>
                </a>
                <nav class="hidden md:flex items-center gap-7 text-sm font-medium">
                    <a href="{{ route('storefront.home') }}" class="hover:text-[#F6C76E] {{ request()->routeIs('storefront.home') ? 'text-[#F6C76E]' : '' }}">Home</a>
                    <a href="{{ route('storefront.shop') }}" class="hover:text-[#F6C76E] {{ request()->routeIs('storefront.shop*') ? 'text-[#F6C76E]' : '' }}">Shop</a>
                    <a href="{{ route('storefront.booking.create') }}" class="hover:text-[#F6C76E] {{ request()->routeIs('storefront.booking*') ? 'text-[#F6C76E]' : '' }}">Book Catering</a>
                </nav>
                <div class="flex items-center gap-4">
                    <a href="{{ route('storefront.cart') }}" class="relative flex items-center gap-1.5 text-sm font-medium hover:text-[#F6C76E]">
                        <span>🛒</span>
                        <span class="hidden sm:inline">Cart</span>
                        @if ($cartCount > 0)
                            <span class="absolute -top-2 -right-3 bg-[#F6C76E] text-[#111318] text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('login') }}" class="text-xs text-[#c4c0b9] hover:text-white border-l border-white/10 pl-4">Staff Login</a>
                </div>
            </div>
            <div class="md:hidden flex items-center gap-4 text-xs pb-3 text-white/80">
                <a href="{{ route('storefront.home') }}">Home</a>
                <a href="{{ route('storefront.shop') }}">Shop</a>
                <a href="{{ route('storefront.booking.create') }}">Book Catering</a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 md:px-8 py-8 md:py-10">
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-[#111318] text-[#8C8A85] text-xs mt-16">
        <div class="max-w-6xl mx-auto px-4 md:px-8 py-8 flex flex-col md:flex-row justify-between gap-3">
            <div>&copy; {{ now()->year }} MA Hospitality &amp; Mart. Catering &middot; Events &middot; Retail.</div>
            <a href="{{ route('login') }}" class="hover:text-white">Staff Login</a>
        </div>
    </footer>
</body>
</html>
