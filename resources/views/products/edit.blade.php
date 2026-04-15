@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-8"
    x-data="{
        name: @js($product->name),
        category_id: @js($product->category_id),
        price: @js($product->price)
    }">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-black dark:text-white">
            Edit Product
        </h2>

        <a href="/products"
            class="text-gray-500 dark:text-white/60 hover:text-black dark:hover:text-white font-medium">
            Back to list
        </a>
    </div>

    <div class="bg-white dark:bg-[#18181c] p-6 my-20 rounded-sm shadow-sm border border-gray-200 dark:border-white/10">

        <form action="/products/{{ $product->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 dark:text-white/60 mb-1">
                    Product Name
                </label>

                <input type="text"
                    name="name"
                    x-model="name"
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-white/10
                           bg-white dark:bg-[#18181c] text-black dark:text-white
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 dark:text-white/60 mb-1">
                    Category
                </label>

                <select name="category_id"
                    x-model="category_id"
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-white/10
                           bg-white dark:bg-[#18181c] text-black dark:text-white
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    <option value="">Select a category</option>

                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 dark:text-white/60 mb-1">
                    Price ($)
                </label>

                <input type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    x-model="price"
                    class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-white/10
                           bg-white dark:bg-[#18181c] text-black dark:text-white
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded-md font-medium transition">
                    Update Product
                </button>
            </div>

        </form>
    </div>
</div>
@endsection