@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-black dark:text-white">
            Edit Product
        </h2>

        <a href="/products"
            class="flex items-center gap-2 text-gray-600 dark:text-white/60 hover:text-indigo-500 dark:hover:text-indigo-400 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="w-5 h-5">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>

            <span class="font-medium">Back</span>
        </a>
    </div>

    <div class="bg-white dark:bg-[#18181c] p-6 rounded-lg shadow-sm border border-gray-200 dark:border-white/10 transition-colors">

        <form action="/products/{{ $product->id }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Product Name --}}
            <div class="mb-5">
                <label for="name"
                    class="block text-sm font-medium text-gray-700 dark:text-white/70 mb-1">
                    Product Name
                </label>

                <input type="text"
                    name="name"
                    id="name"
                    value="{{ $product->name }}"
                    class="w-full border border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-black dark:text-white px-3 py-2 rounded-md
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    required>
            </div>

            {{-- Category --}}
            <div class="mb-5">
                <label for="category_id"
                    class="block text-sm font-medium text-gray-700 dark:text-white/70 mb-1">
                    Category
                </label>

                <select name="category_id"
                    id="category_id"
                    class="w-full border border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-black dark:text-white px-3 py-2 rounded-md
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">

                    <option value="">Select a category</option>

                    @if(isset($categories))
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                    @endif

                </select>
            </div>

            {{-- Price --}}
            <div class="mb-5">
                <label for="price"
                    class="block text-sm font-medium text-gray-700 dark:text-white/70 mb-1">
                    Price ($)
                </label>

                <input type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    id="price"
                    value="{{ $product->price }}"
                    class="w-full border border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-black dark:text-white px-3 py-2 rounded-md
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    required>
            </div>

            {{-- Submit --}}
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