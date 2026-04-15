@extends('layouts.app')

@section('content')
<div class="px-6 py-8"
    x-data="{
        search: '',
        sort: 'alpha-asc',

        categories: @js($categories->map(fn($c) => [
            'id' => $c->id,
            'name' => $c->name,
        ])),

        get processed() {
            let data = this.categories.filter(c => {
                return this.search === '' ||
                    c.name.toLowerCase().includes(this.search.toLowerCase());
            });

            switch (this.sort) {
                case 'alpha-asc':
                    data.sort((a, b) => a.name.localeCompare(b.name));
                    break;

                case 'alpha-desc':
                    data.sort((a, b) => b.name.localeCompare(a.name));
                    break;

                case 'id-asc':
                    data.sort((a, b) => a.id - b.id);
                    break;

                case 'id-desc':
                    data.sort((a, b) => b.id - a.id);
                    break;
            }

            return data;
        }
    }">

    <div class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-bold text-black dark:text-white">
            Categories
        </h2>

        <a href="/categories/create"
            class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md font-medium transition">
            + New Category
        </a>
    </div>

    <div class="mb-10 flex gap-3">

        <input type="text"
            x-model="search"
            placeholder="Search category..."
            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-white/10
                   bg-white dark:bg-[#18181c] text-black dark:text-white
                   focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <select x-model="sort"
            class="px-3 py-2 rounded-md border border-gray-300 dark:border-white/10
                   bg-white dark:bg-[#18181c] text-black dark:text-white">

            <option value="alpha-asc">Name (A → Z)</option>
            <option value="alpha-desc">Name (Z → A)</option>
            <option value="id-asc">ID (Lowest First)</option>
            <option value="id-desc">ID (Highest First)</option>

        </select>

    </div>

    <div class="bg-white dark:bg-[#18181c] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden">

        <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">

            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-white/60 uppercase">
                        ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-white/60 uppercase">
                        Name
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-white/60 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-white/10">

                <template x-for="c in processed" :key="c.id">
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition cursor-pointer"
                        @click="window.location='/categories/' + c.id">

                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-white/60"
                            x-text="c.id"></td>

                        <td class="px-6 py-4 text-sm font-medium text-black dark:text-white"
                            x-text="c.name"></td>

                        <td class="px-6 py-4 text-right text-sm font-medium">

                            <a :href="`/categories/${c.id}/edit`"
                                class="text-indigo-500 hover:underline mr-4"
                                @click.stop>
                                Edit
                            </a>

                            <form :action="`/categories/${c.id}`" method="POST"
                                class="inline-block"
                                @click.stop
                                @submit.prevent="if(confirm('Are you sure you want to delete this category?')) $el.submit()">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="text-red-500 hover:underline hover:cursor-pointer"
                                    @click.stop>
                                    Delete
                                </button>

                            </form>

                        </td>
                    </tr>
                </template>

                <tr x-show="processed.length === 0">
                    <td colspan="3" class="px-6 py-10 text-center text-gray-500 dark:text-white/50">
                        No categories found
                    </td>
                </tr>

            </tbody>

        </table>

    </div>
</div>
@endsection