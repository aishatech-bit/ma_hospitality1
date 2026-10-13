@extends('layouts.app')

@section('title', 'New Catering Booking')

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
        @csrf
        @include('bookings._form')
        <button class="bg-[#111318] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-black">Create Booking</button>
    </form>
</div>
@endsection
