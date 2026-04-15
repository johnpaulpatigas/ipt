<header class="bg-white dark:bg-[#18181c] border-b border-gray-200 dark:border-white/10 px-6 h-14 flex items-center justify-between transition-colors duration-300"
    x-data="{ open: false }">

    <!-- LOGO -->
    <a href="/" class="flex items-center gap-2 no-underline">
        <div class="w-7 h-7 bg-indigo-500 rounded-lg flex items-center justify-center">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round">
                <polygon points="12 2 19 7 19 17 12 22 5 17 5 7" />
                <line x1="12" y1="2" x2="12" y2="22" />
            </svg>
        </div>

        <span class="font-bold text-black dark:text-white">
            IPT App
        </span>
    </a>

    <!-- DESKTOP NAV -->
    <nav class="hidden md:flex items-center gap-2">

        <a href="/"
            class="px-3 py-1.5 text-sm rounded-md transition
           {{ request()->is('/') ? 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-white/60 hover:bg-white/10' }}">
            Home
        </a>

        <a href="/categories"
            class="px-3 py-1.5 text-sm rounded-md transition
           {{ request()->is('categories*') ? 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-white/60 hover:bg-white/10' }}">
            Categories
        </a>

        <a href="/products"
            class="px-3 py-1.5 text-sm rounded-md transition
           {{ request()->is('products*') ? 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-white/60 hover:bg-white/10' }}">
            Products
        </a>

    </nav>

    <!-- BURGER BUTTON -->
    <button class="md:hidden text-gray-600 dark:text-white/70"
        @click="open = !open">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />

        </svg>

    </button>

    <!-- MOBILE MENU -->
    <div x-show="open"
        x-transition
        class="absolute top-14 left-0 w-full bg-white dark:bg-[#18181c] border-b border-gray-200 dark:border-white/10 md:hidden">

        <div class="flex flex-col p-4 gap-2">

            <a href="/"
                class="px-3 py-2 rounded-md text-sm
               {{ request()->is('/') ? 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-white/60' }}">
                Home
            </a>

            <a href="/categories"
                class="px-3 py-2 rounded-md text-sm
               {{ request()->is('categories*') ? 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-white/60' }}">
                Categories
            </a>

            <a href="/products"
                class="px-3 py-2 rounded-md text-sm
               {{ request()->is('products*') ? 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-white/60' }}">
                Products
            </a>

        </div>

    </div>

</header>