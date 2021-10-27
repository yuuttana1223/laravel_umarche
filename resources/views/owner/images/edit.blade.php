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
                    <form action="{{ route('owner.images.update', $image) }}" method="post"
                        enctype="multipart/form-data" class="-m-2">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @csrf
                        @method('PATCH')
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="title" class="leading-7 text-sm text-gray-600">画像のタイトル</label>
                            <input type="text" id="title" name="title" value="{{ $image->title }}"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <div class="w-full">
                                <x-thumbnail :filename="$image->filename" dirname="products" />
                            </div>
                        </div>
                        <div class="p-2 w-full flex justify-around mt-4">
                            <a type="button" href="{{ route('owner.images.index') }}"
                                class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</a>
                            <button
                                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                        </div>
                    </form>
                    <form action="{{ route('owner.images.destroy', $image) }}" method="post" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <div class="w-full text-center p-2 mt-4">
                            <button
                                class="text-white bg-red-400 border-0 py-1 md:py-2 px-1 md:px-4 focus:outline-none hover:bg-red-500 rounded">
                                削除
                            </button>
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
