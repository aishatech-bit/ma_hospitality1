@extends('layouts.app')

@section('title', 'Sales')
@section('subtitle', 'Recorded transactions and sales history.')
@section('actions')
    <a href="{{ route('sales.create') }}" class="bg-[#111318] text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-black">+ Record Sale</a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-black/5">
        <form method="GET" class="flex gap-2">
            <input type="date" name="date" value="{{ request('date') }}"
                   class="rounded-lg border border-black/10 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
            <button class="bg-[#F6F5F2] px-4 py-2 rounded-lg text-sm font-medium border border-black/10">Filter</button>
            @if(request('date'))
                <a href="{{ route('sales.index') }}" class="px-4 py-2 text-sm text-[#6B6862]">Clear</a>
            @endif
        </form>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-[#F6F5F2] text-[#6B6862] text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">#</th>
                <th class="text-left px-4 py-3">Date</th>
                <th class="text-left px-4 py-3">Customer</th>
                <th class="text-left px-4 py-3">Channel</th>
                <th class="text-left px-4 py-3">Status</th>
                <th class="text-right px-4 py-3">Total</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($sales as $sale)
                <tr class="{{ $sale->status === 'pending' ? 'bg-amber-50/50' : '' }}">
                    <td class="px-4 py-3 font-medium">#{{ $sale->id }}</td>
                    <td class="px-4 py-3 text-[#6B6862]">{{ $sale->sale_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $sale->customer->name ?? 'Walk-in' }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $sale->channel === 'online' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $sale->channel === 'online' ? 'Online' : 'In-store' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $sale->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold">&#8358;{{ number_format($sale->total, 2) }}</td>
                    <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap">
                        <a href="{{ route('sales.show', $sale) }}" class="text-[#C9A24B] font-medium hover:underline">View</a>
                        @if ($sale->status === 'pending')
                            <form method="POST" action="{{ route('sales.fulfil', $sale) }}" class="inline">
                                @csrf
                                <button class="text-emerald-600 font-medium hover:underline">Mark Fulfilled</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-[#8C8A85]">No sales recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-black/5">{{ $sales->links() }}</div>
</div>
@endsection
