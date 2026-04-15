@extends('layouts.app')

@section('content')
<div class="px-6 py-8"
    x-data="{
        open: false,
        product: null,
        search: '',
        category: '',

        products: @js($products->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'category' => $p->category->name ?? 'Uncategorized',
            'price' => number_format($p->price, 2),
        ])),

        get filtered() {
            return this.products.filter(p => {
                return (
                    (this.search === '' || p.name.toLowerCase().includes(this.search.toLowerCase())) &&
                    (this.category === '' || p.category === this.category)
                );
            });
        }
    }">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-black dark:text-white">
            Products
        </h2>

        <a href="/products/create"
            class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md font-medium transition">
            + New Product
        </a>
    </div>

    <div class="mb-4 flex gap-3">

        <input type="text"
            x-model="search"
            placeholder="Search product..."
            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-white/10
                   bg-white dark:bg-[#18181c] text-black dark:text-white
                   focus:outline-none focus:ring-2 focus:ring-indigo-500">

        @php
        $categories = $products->map(fn($p) => $p->category->name ?? 'Uncategorized')->unique();
        @endphp

        <select x-model="category"
            class="px-3 py-2 rounded-md border border-gray-300 dark:border-white/10
                   bg-white dark:bg-[#18181c] text-black dark:text-white">

            <option value="">All Categories</option>

            @foreach($categories as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach

        </select>

    </div>

    <div class="bg-white dark:bg-[#18181c] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden">

        <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">

            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-white/60 uppercase">
                        Product Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-white/60 uppercase">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-white/60 uppercase">
                        Price
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-white/10">

                <template x-for="p in filtered" :key="p.id">

                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition cursor-pointer"
                        @click="open = true; product = p">

                        <td class="px-6 py-4 text-sm font-medium text-black dark:text-white"
                            x-text="p.name"></td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-white/60"
                            x-text="p.category"></td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-white/60"
                            x-text="'$' + p.price"></td>

                    </tr>

                </template>

                <tr x-show="filtered.length === 0">
                    <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-white/50">
                        No products found
                    </td>
                </tr>

            </tbody>

        </table>
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
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm font-medium transition">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    </x-product-modal>

</div>
@endsection