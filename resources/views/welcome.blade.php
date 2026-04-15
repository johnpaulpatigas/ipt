@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-6 bg-white dark:bg-[#18181c] transition-colors duration-300">

    <div class="w-full max-w-2xl p-10 text-center">

        <h1 class="text-3xl md:text-4xl font-bold text-black dark:text-white mb-4 tracking-tight">
            A SIMPLE CATEGORIZATION APP
        </h1>

        <p class="text-black/60 dark:text-white/60 mb-8 text-base md:text-lg">
            Manage your products and categories seamlessly.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">

            <a href="/categories"
                class="bg-indigo-500/20 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-500/30 px-6 py-2.5 rounded-lg font-medium transition">
                Manage Categories
            </a>

            <a href="/products"
                class="bg-indigo-500 text-white hover:bg-indigo-600 px-6 py-2.5 rounded-lg font-medium transition">
                Manage Products
            </a>

        </div>

    </div>

</div>
@endsection