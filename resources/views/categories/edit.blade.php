@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Category</h2>
        <a href="/categories" class="text-gray-600 hover:text-gray-900 font-medium">Back to list</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <form action="/categories/{{ $category->id }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" name="name" id="name" value="{{ $category->name }}" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md font-medium transition">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection