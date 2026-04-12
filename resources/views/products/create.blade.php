@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Create Product</h2>
        <a href="/products" class="text-gray-600 hover:text-gray-900 font-medium">Back to list</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <form action="/products" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div class="mb-5">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" id="category_id" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select a category</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="mb-5">
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                <input type="number" step="0.01" min="0" name="price" id="price" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md font-medium transition">Save Product</button>
            </div>
        </form>
    </div>
</div>
@endsection