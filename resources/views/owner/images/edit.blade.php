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
                    <form action="{{ route('owner.shops.update', $shop) }}" method="post"
                        enctype="multipart/form-data" class="-m-2">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @csrf
                        @method('PATCH')
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="name" class="leading-7 text-sm text-gray-600">店名 ※必須</label>
                            <input type="text" id="name" name="name" value="{{ $shop->name }}" required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="information" class="leading-7 text-sm text-gray-600">店舗情報 ※必須</label>
                            <textarea type="text" id="information" name="information" required rows="10"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $shop->information }}</textarea>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <div class="w-1/2">
                                <x-shop-thumbnail :filename="$shop->filename" />
                            </div>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                            <input type="file" id="image" name="image" accept=".png, .jpeg, .jpg"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                        </div>
                        <div class="p-2 w-1/2 mx-auto text-right">
                            <label class="mr-2">
                                <input type="radio" name="is_selling" value="1" class="mr-1"
                                    {{ $shop->is_selling ? 'checked' : '' }}>販売中
                            </label>
                            <label>
                                <input type="radio" name="is_selling" value="0" class="mr-1"
                                    {{ $shop->is_selling ? '' : 'checked' }}>停止中
                            </label>
                        </div>
                        <div class="p-2 w-full flex justify-around mt-4">
                            <a type="button" href="{{ route('owner.shops.index') }}"
                                class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</a>
                            <button
                                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
