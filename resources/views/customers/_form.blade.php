@php $c = $customer ?? null; @endphp
<div>
    <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Full Name</label>
    <input type="text" name="name" value="{{ old('name', $c->name ?? '') }}" required
           class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $c->phone ?? '') }}"
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
    </div>
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Email</label>
        <input type="email" name="email" value="{{ old('email', $c->email ?? '') }}"
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
    </div>
</div>
<div>
    <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Address</label>
    <input type="text" name="address" value="{{ old('address', $c->address ?? '') }}"
           class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
</div>
