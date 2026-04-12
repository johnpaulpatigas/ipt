@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-sm text-center mt-10">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to IPT App</h1>
    <p class="text-gray-600 mb-8 text-lg">Manage your products and categories seamlessly.</p>
    <div class="flex justify-center space-x-4">
        <a href="/categories" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">Manage Categories</a>
        <a href="/products" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium transition">Manage Products</a>
    </div>
</div>
@endsection