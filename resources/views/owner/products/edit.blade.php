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
                    <form action="{{ route('owner.products.update', $product) }}" method="post" class="-m-2">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <x-flash-message :status="session('status')" />
                        @csrf
                        @method('PATCH')
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="name" class="text-sm leading-7 text-gray-600">商品名 ※必須</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                                required
                                class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="information" class="text-sm leading-7 text-gray-600">商品情報 ※必須</label>
                            <textarea type="text" id="information" name="information" required rows="10"
                                class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">{{ old('information', $product->information) }}</textarea>
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="price" class="text-sm leading-7 text-gray-600">価格 ※必須</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                                required
                                class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <h3 class="text-sm leading-7 text-gray-600">現在の在庫</h3>
                            {{-- 楽観的ロック用 --}}
                            <input type="hidden" id="current_quantity" name="current_quantity"
                                value="{{ $quantity }}">
                            <p class="px-3 py-1 leading-8">
                                {{ $quantity }}</p>
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="quantity" class="block text-sm leading-7 text-gray-600"></label>
                            <div class="flex justify-between">
                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}"
                                    required
                                    class="w-1/2 px-3 py-1 leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200">
                                <div class="leading-9">
                                    <label class="mr-2">
                                        <input type="radio" name="type" value="{{ \ProductConstant::ADD }}"
                                            class="mr-1"
                                            {{ old('type') === \ProductConstant::ADD ? 'checked' : '' }}
                                            {{ is_null(old('type')) ? 'checked' : '' }} id="add">増やす
                                    </label>
                                    <label>
                                        <input type="radio" name="type" value="{{ \ProductConstant::REDUCE }}"
                                            class="mr-1"
                                            {{ old('type') === \ProductConstant::REDUCE ? 'checked' : '' }}>減らす
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-1/2 p-2 mx-auto">
                            <label for="shop_id" class="text-sm leading-7 text-gray-600">販売する店舗 ※必須</label>
                            <select name="shop_id" id="shop_id"
                                class="w-full px-3 py-1 leading-8 text-gray-700 bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none">
                                @foreach ($shops as $shop)
                                    <option value="{{ old('shop_id', $shop->id) }}">
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
                                            <option value="{{ $secondaryCategory->id }}" @if (!is_null(old('secondary_category_id')))
                                                {{ old('secondary_category_id') === (string) $secondaryCategory->id ? 'selected' : '' }}>
                                            @else
                                                {{ $product->secondary_category_id === $secondaryCategory->id ? 'selected' : '' }}>
                                        @endif
                                        {{ $secondaryCategory->name }}
                                        </option>
                                @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/2 p-2 mx-auto mb-8 text-right">
                            <label class="mr-2">
                                <input type="radio" name="is_selling" value="1" class="mr-1"
                                    {{ old('is_selling', (string) $product->is_selling) === '1' ? 'checked' : '' }}>販売中
                            </label>
                            <label>
                                <input type="radio" name="is_selling" value="0" class="mr-1"
                                    {{ old('is_selling', (string) $product->is_selling) === '0' ? 'checked' : '' }}>停止中
                            </label>
                        </div>
                        <x-modal>
                            <x-slot name="modalHeader">
                                画像を選択してください
                            </x-slot>
                            <x-slot name="modalContent">
                                <div class="flex flex-wrap">
                                    @foreach ($images as $image)
                                        <div class="w-1/4 p-2">
                                            <img class="p-2 border rounded-md cursor-pointer image hover:opacity-80 md:p-4 md:pb-8"
                                                data-id="{{ $image->id }}"
                                                src="{{ asset("storage/products/{$image->filename}") }}"
                                                alt="{{ $image->title }}" />
                                        </div>
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-modal>

                        @foreach ($currentImages as $image)
                            <div class="flex items-center justify-around h-48 mb-4">
                                <a data-micromodal-trigger="modal-1" href='javascript:;'
                                    class="bg-gray-200 md:py-1 md:px-2">画像を編集</a>
                                <input type="hidden" name="image{{ $loop->index + 1 }}" @if((is_null(old('image' . $loop->index + 1)))) value="{{ $image->id ?? '' }}" @else value="{{ old('image' . $loop->index + 1) ?? '' }}" @endif>
                                <div class="w-1/4" id="image-wrap{{ $loop->index + 1 }}">
                                    @if (is_null(old('image' . $loop->index + 1)) && isset($image->filename))
                                        <img src="{{ asset("storage/products/{$image->filename}") }}"
                                            alt="{{ $image->title }}" class="p-2 border rounded-md md:p-4 md:pb-6">
                                    @elseif (isset($images[old('image' . $loop->index + 1) - 1]->filename))
                                        <img src="{{ asset('storage/products/' . $images[old('image' . $loop->index + 1) - 1]->filename) }}"
                                            alt="{{ $images[old('image' . $loop->index + 1) - 1]->title }}"
                                            class="p-2 border rounded-md md:p-4 md:pb-6">
                                    @endif
                                </div>
                                <button type="button" class="bg-red-400 delete-image md:py-1 md:px-2">画像を削除</button>
                            </div>
                        @endforeach
                        <div class="flex justify-around w-full p-2 mt-4">
                            <a type="button" href="{{ route('owner.products.index') }}"
                                class="px-8 py-2 text-lg bg-gray-200 border-0 rounded focus:outline-none hover:bg-gray-400">戻る</a>
                            <button
                                class="px-8 py-2 text-lg text-white bg-indigo-500 border-0 rounded focus:outline-none hover:bg-indigo-600">更新</button>
                        </div>
                    </form>
                    <form action="{{ route('owner.products.destroy', $product) }}" method="post"
                        class="delete-form">
                        @csrf
                        @method('DELETE')
                        <div class="w-full p-2 mt-4 text-center">
                            <button
                                class="px-8 py-2 text-lg text-white bg-red-400 border-0 rounded focus:outline-none hover:bg-red-500">
                                削除
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/micromodal.js') }}"></script>
    <script src="{{ asset('js/owner/products/edit.js') }}"></script>
</x-app-layout>
