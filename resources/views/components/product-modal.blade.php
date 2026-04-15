<div x-show="open"
    x-transition
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white dark:bg-[#18181c] w-full max-w-md rounded-sm p-6 border border-gray-200 dark:border-white/10">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-black dark:text-white">
                {{ $title ?? 'Details' }}
            </h3>

            <button @click="open = false"
                class="text-gray-500 hover:text-red-500 hover:cursor-pointer">
                ✕
            </button>
        </div>

        {{ $slot }}

    </div>
</div>