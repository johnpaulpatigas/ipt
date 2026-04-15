@extends('layouts.app')

@section('content')
<div class="px-6 py-8 max-w-4xl mx-auto"
    x-data="{ open: false, product: null }">

    <div class="flex items-center justify-between mb-6">

        <h2 class="text-3xl font-bold text-black dark:text-white">
            {{ $category->name }}
        </h2>

        <a href="/categories"
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

    <div class="bg-white dark:bg-[#18181c] rounded-sm border border-gray-200 dark:border-white/10 overflow-hidden">

        @if($category->products->count() > 0)

        <ul class="divide-y divide-gray-200 dark:divide-white/10">

            @foreach($category->products as $product)
            <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-white/5 transition cursor-pointer"
                @click="open = true; product = {
                    id: {{ $product->id }},
                    name: '{{ $product->name }}',
                    category: '{{ $category->name }}',
                    price: '{{ number_format($product->price, 2) }}'
                }">

                <div class="text-black dark:text-white font-medium">
                    {{ $product->name }}
                </div>

                <div class="text-indigo-600 dark:text-indigo-400 font-semibold">
                    ${{ number_format($product->price, 2) }}
                </div>

            </li>
            @endforeach

        </ul>

        @else

        <div class="flex flex-col items-center justify-center py-12 text-center">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-12 h-12 text-gray-400 dark:text-white/30 mb-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0l-6 6m6-6H4" />

            </svg>

            <p class="text-gray-500 dark:text-white/50">
                No products in this category
            </p>

        </div>

        @endif

    </div>

    <x-product-modal title="Product Details">

        <div class="space-y-4">

            <div>
                <p class="text-gray-500 dark:text-white/50 text-sm">Name</p>
                <p class="text-black dark:text-white font-medium" x-text="product?.name"></p>
            </div>

            <div>
                <p class="text-gray-500 dark:text-white/50 text-sm">Category</p>
                <p class="text-black dark:text-white" x-text="product?.category"></p>
            </div>

            <div>
                <p class="text-gray-500 dark:text-white/50 text-sm">Price</p>
                <p class="text-indigo-500 font-semibold" x-text="'$' + product?.price"></p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-white/10">

                <a :href="`/products/${product?.id}/edit`"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md text-sm font-medium transition">
                    Edit
                </a>

                <form :action="`/products/${product?.id}`" method="POST"
                    onsubmit="return confirm('Delete this product?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm font-medium transition hover:cursor-pointer">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    </x-product-modal>

</div>
@endsection