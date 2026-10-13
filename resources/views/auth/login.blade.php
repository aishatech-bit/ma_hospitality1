<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in — MA Hospitality & Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body{font-family:'Plus Jakarta Sans',sans-serif;}</style>
</head>
<body class="min-h-screen bg-[#111318] flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="text-xs tracking-[0.35em] text-[#C9A24B] uppercase">MA Hospitality</div>
            <div class="text-2xl font-bold text-white">&amp; Mart</div>
            <p class="text-[#8C8A85] text-sm mt-2">Catering, Inventory &amp; Sales Management</p>
        </div>

        <div class="bg-[#191B21] rounded-2xl shadow-xl border border-white/5 p-8">
            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 text-sm">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-[#B8B6B0] mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg bg-[#111318] border border-white/10 px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-[#B8B6B0] mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-lg bg-[#111318] border border-white/10 px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
                </div>
                <label class="flex items-center gap-2 text-xs text-[#8C8A85]">
                    <input type="checkbox" name="remember" class="rounded border-white/20 bg-[#111318]">
                    Remember me
                </label>
                <button type="submit"
                        class="w-full bg-[#C9A24B] text-[#111318] font-semibold rounded-lg py-2.5 text-sm hover:bg-[#dab35f] transition">
                    Sign in
                </button>
            </form>
        </div>

        <p class="text-center text-[#6B6862] text-xs mt-6">
            Demo: admin@mahospitalityandmart.test / password
        </p>
    </div>
</body>
</html>
