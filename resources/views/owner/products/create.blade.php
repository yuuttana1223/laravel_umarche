<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('owner.products.store') }}" method="post" class="-m-2">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @csrf
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー</label>
                            <select name="category" id="category"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                                @foreach ($categories as $primaryCategory)
                                    <optgroup label="{{ $primaryCategory->name }}">
                                        @foreach ($primaryCategory->categories as $secondaryCategory)
                                            <option value="{{ $secondaryCategory->id }}">
                                                {{ $secondaryCategory->name }}
                                            </option>
                                        @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="p-2 w-full flex justify-around mt-4">
                            <a type="button" href="{{ route('owner.products.index') }}"
                                class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</a>
                            <button
                                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        "use strict";

        {
            document.querySelector(".delete-form").addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("本当に削除してもいいですか?")) {
                    return;
                }
                e.target.submit();
            })
        }
    </script>
</x-app-layout>
