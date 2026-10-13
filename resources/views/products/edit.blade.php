@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-4">
        @csrf @method('PUT')
        @include('products._form')
        <button class="bg-[#111318] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-black">Update Product</button>
    </form>
</div>
@endsection
