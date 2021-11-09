<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('owner.images.update', $image) }}" method="post"
                        enctype="multipart/form-data" class="-m-2">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @csrf
                        @method('PATCH')
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="title" class="text-sm leading-7 text-gray-600">画像のタイトル</label>
                            <input type="text" id="title" name="title" value="{{ $image->title }}"
                                class="w-full px-3 py-1 leading-8 text-gray-700 bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none">
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <div class="w-full">
                                <x-thumbnail :filename="$image->filename" dirname="products"
                                    alt="{{ $image->title ?? '' }}" />
                            </div>
                        </div>
                        <div class="flex justify-around w-full p-2 mt-4">
                            <a type="button" href="{{ route('owner.images.index') }}"
                                class="px-8 py-2 text-lg bg-gray-200 border-0 rounded focus:outline-none hover:bg-gray-400">戻る</a>
                            <button
                                class="px-8 py-2 text-lg text-white bg-indigo-500 border-0 rounded focus:outline-none hover:bg-indigo-600">更新</button>
                        </div>
                    </form>
                    <form action="{{ route('owner.images.destroy', $image) }}" method="post" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <div class="w-full p-2 mt-4 text-center">
                            <button
                                class="px-1 py-1 text-white bg-red-400 border-0 rounded md:py-2 md:px-4 focus:outline-none hover:bg-red-500">
                                削除
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/owner/images/edit.js') }}"></script>
</x-app-layout>
