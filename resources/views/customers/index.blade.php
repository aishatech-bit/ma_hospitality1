@extends('layouts.app')

@section('title', 'Customers')
@section('subtitle', 'Everyone who has bought from or booked the business.')
@section('actions')
    <a href="{{ route('customers.create') }}" class="bg-[#111318] text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-black">+ Add Customer</a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-black/5">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or phone..."
                   class="flex-1 rounded-lg border border-black/10 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
            <button class="bg-[#F6F5F2] px-4 py-2 rounded-lg text-sm font-medium border border-black/10">Search</button>
        </form>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-[#F6F5F2] text-[#6B6862] text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">Name</th>
                <th class="text-left px-4 py-3">Phone</th>
                <th class="text-left px-4 py-3">Email</th>
                <th class="text-left px-4 py-3">Address</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($customers as $customer)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $customer->name }}</td>
                    <td class="px-4 py-3 text-[#6B6862]">{{ $customer->phone ?? '—' }}</td>
                    <td class="px-4 py-3 text-[#6B6862]">{{ $customer->email ?? '—' }}</td>
                    <td class="px-4 py-3 text-[#6B6862]">{{ $customer->address ?? '—' }}</td>
                    <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap">
                        <a href="{{ route('customers.edit', $customer) }}" class="text-[#C9A24B] font-medium hover:underline">Edit</a>
                        <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="inline" onsubmit="return confirm('Remove this customer?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 font-medium hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-[#8C8A85]">No customers found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-black/5">{{ $customers->links() }}</div>
</div>
@endsection
