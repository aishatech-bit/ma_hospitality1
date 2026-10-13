<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — MA Hospitality & Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
    </style>
</head>
<body class="bg-[#F6F5F2] text-[#1C1C1C]">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#111318] text-[#E9E7E1] flex-shrink-0 hidden md:flex md:flex-col">
            <div class="px-6 py-6 border-b border-white/10">
                <div class="text-xs tracking-[0.3em] text-[#C9A24B] uppercase">MA Hospitality</div>
                <div class="text-lg font-bold">&amp; Mart</div>
            </div>
            <nav class="flex-1 px-3 py-6 space-y-1 text-sm">
                @php
                    $nav = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => '&#9673;'],
                        ['route' => 'products.index', 'label' => 'Inventory', 'icon' => '&#9635;'],
                        ['route' => 'sales.index', 'label' => 'Sales', 'icon' => '&#8353;'],
                        ['route' => 'customers.index', 'label' => 'Customers', 'icon' => '&#9679;'],
                        ['route' => 'bookings.index', 'label' => 'Catering Bookings', 'icon' => '&#128197;'],
                        ['route' => 'reports.index', 'label' => 'Reports', 'icon' => '&#128202;'],
                    ];
                @endphp
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                              {{ request()->routeIs($item['route']) || (str($item['route'])->contains('.') && request()->routeIs(str($item['route'])->before('.').'.*'))
                                    ? 'bg-[#C9A24B]/15 text-[#C9A24B] font-semibold'
                                    : 'text-[#B8B6B0] hover:bg-white/5 hover:text-white' }}">
                        <span class="text-base">{!! $item['icon'] !!}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="px-4 py-4 border-t border-white/10 text-xs text-[#8C8A85]">
                <a href="{{ route('storefront.home') }}" target="_blank" class="block mb-3 text-[#C9A24B] hover:underline">View Storefront &rarr;</a>
                <div class="font-medium text-[#E9E7E1]">{{ auth()->user()->name ?? '' }}</div>
                <div class="mb-3 capitalize">{{ auth()->user()->role ?? '' }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left text-[#C9A24B] hover:underline">Sign out</button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="md:hidden bg-[#111318] text-white px-4 py-3 flex items-center justify-between">
                <span class="font-bold">MA Hospitality &amp; Mart</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-[#C9A24B] text-sm">Sign out</button>
                </form>
            </header>

            <main class="flex-1 p-4 md:p-8 max-w-6xl w-full mx-auto">
                <div class="mb-6 flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <h1 class="text-2xl font-bold text-[#111318]">@yield('title', 'Dashboard')</h1>
                        @hasSection('subtitle')
                            <p class="text-sm text-[#6B6862] mt-1">@yield('subtitle')</p>
                        @endif
                    </div>
                    @hasSection('actions')
                        <div>@yield('actions')</div>
                    @endif
                </div>

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
        </div>
    </div>
</body>
</html>
