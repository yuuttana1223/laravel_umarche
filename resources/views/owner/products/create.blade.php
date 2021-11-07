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
                    <form action="{{ route('owner.products.store') }}" method="post" class="-m-2">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @csrf
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="name" class="text-sm leading-7 text-gray-600">商品名 ※必須</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="information" class="text-sm leading-7 text-gray-600">商品情報 ※必須</label>
                            <textarea type="text" id="information" name="information" required rows="10"
                                class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">{{ old('information') }}</textarea>
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="price" class="text-sm leading-7 text-gray-600">価格 ※必須</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" required
                                class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="quantity" class="text-sm leading-7 text-gray-600">初期在庫数 ※必須</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required
                                class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="shop_id" class="text-sm leading-7 text-gray-600">販売する店舗 ※必須</label>
                            <select name="shop_id" id="shop_id"
                                class="w-full px-3 py-1 leading-8 text-gray-700 bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none">
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}">
                                        {{ $shop->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/2 p-2 mx-auto mb-8">
                            <label for="secondary_category_id" class="text-sm leading-7 text-gray-600">カテゴリー ※必須</label>
                            <select name="secondary_category_id" id="secondary_category_id"
                                class="w-full px-3 py-1 leading-8 text-gray-700 bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none">
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
                        <div class="w-1/2 p-2 mx-auto mb-8 text-right">
                            <label class="mr-2">
                                <input type="radio" name="is_selling" value="1" class="mr-1" checked>販売中
                            </label>
                            <label>
                                <input type="radio" name="is_selling" value="0" class="mr-1">停止中
                            </label>
                        </div>
                        <x-select-image-modal :images="$images" />
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="flex items-center justify-around h-48 mb-4">
                                <a data-micromodal-trigger="modal-1" href='javascript:;'
                                    class="bg-gray-200 md:py-1 md:px-2">画像を選択</a>
                                <input type="hidden" name="image{{ $i }}">
                                <div class="w-1/4" id="image-wrap{{ $i }}">
                                </div>
                            </div>
                        @endfor
                </div>
            </div>
            <div class="flex justify-around w-full p-2 mt-4">
                <a type="button" href="{{ route('owner.products.index') }}"
                    class="px-8 py-2 text-lg bg-gray-200 border-0 rounded focus:outline-none hover:bg-gray-400">戻る</a>
                <button
                    class="px-8 py-2 text-lg text-white bg-indigo-500 border-0 rounded focus:outline-none hover:bg-indigo-600">登録</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    <script src="{{ mix('js/micromodal.js') }}"></script>
    <script src="{{ asset('js/owner/products/create.js') }}"></script>
</x-app-layout>
