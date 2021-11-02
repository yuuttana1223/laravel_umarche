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
                    <form action="{{ route('owner.products.update', $product) }}" method="post" class="-m-2">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        @csrf
                        @method('PATCH')
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                            <input type="text" id="name" name="name" value="{{ $product->name }}" required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                            <textarea type="text" id="information" name="information" required rows="10"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $product->information }}</textarea>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                            <input type="number" id="price" name="price" value="{{ $product->price }}" required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <h3 class="leading-7 text-sm text-gray-600">現在の在庫</h3>
                            <input type="hidden" id="current_quantity" name="current_quantity"
                                value="{{ $quantity }}">
                            <p class="leading-8 py-1 px-3">
                                {{ $quantity }}</p>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="quantity" class="block leading-7 text-sm text-gray-600">数量
                                0~99の範囲で入力してください</label>
                            <div class="flex justify-between">
                                <input type="number" id="quantity" name="quantity" value="0" required
                                    class="w-1/2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200  outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <div class="leading-9">
                                    <label class="mr-2">
                                        <input type="radio" name="type" value="1" class="mr-1" checked>増やす
                                    </label>
                                    <label>
                                        <input type="radio" name="type" value="2" class="mr-1">減らす
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗 ※必須</label>
                            <select name="shop_id" id="shop_id"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}">
                                        {{ $shop->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="p-2 w-1/2 mx-auto mb-8">
                            <label for="secondary_category_id" class="leading-7 text-sm text-gray-600">カテゴリー ※必須</label>
                            <select name="secondary_category_id" id="secondary_category_id"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                                @foreach ($categories as $primaryCategory)
                                    <optgroup label="{{ $primaryCategory->name }}">
                                        @foreach ($primaryCategory->categories as $secondaryCategory)
                                            <option value="{{ $secondaryCategory->id }}"
                                                {{ $product->secondary_category_id === $secondaryCategory->id ? 'selected' : '' }}>
                                                {{ $secondaryCategory->name }}
                                            </option>
                                        @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="p-2 w-1/2 mx-auto text-right mb-8">
                            <label class="mr-2">
                                <input type="radio" name="is_selling" value="1" class="mr-1"
                                    {{ $product->is_selling ? 'checked' : '' }}>販売中
                            </label>
                            <label>
                                <input type="radio" name="is_selling" value="0" class="mr-1"
                                    {{ $product->is_selling ? '' : 'checked' }}>停止中
                            </label>
                        </div>
                        <x-select-image-modal :images="$images" />

                        @foreach ($currentImages as $image)
                            <div class="flex justify-around items-center mb-4 h-48">
                                <a data-micromodal-trigger="modal-1" href='javascript:;'
                                    class="md:py-1 md:px-2 bg-gray-200">画像を編集</a>
                                <input type="hidden" name="image{{ $loop->index + 1 }}">
                                <div class="w-1/4" id="image-wrap{{ $loop->index + 1 }}">
                                    @if (isset($image->filename))
                                        <img src="{{ asset("storage/products/{$image->filename}") }}"
                                            alt="{{ $image->title }}" class="border rounded-md p-2 md:p-4 md:pb-6">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="p-2 w-full flex justify-around mt-4">
                            <a type="button" href="{{ route('owner.products.index') }}"
                                class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</a>
                            <button
                                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        "use strict";

        {
            const selectButtons = document.querySelectorAll("a[href='javascript:;']");

            selectButtons.forEach((selectBtn, index) => {
                selectBtn.addEventListener("click", (e) => {
                    const input = e.target.nextElementSibling
                    // モーダル出現
                    document.querySelectorAll(".image").forEach((modalImage) => {
                        modalImage.onclick = ((e) => {
                            input.value = e.target.dataset.id;
                            const selectImage = document.createElement("img");
                            selectImage.src = modalImage.src;
                            selectImage.className = "border rounded-md p-2 md:p-4 md:pb-6"
                            const imageParent = document.getElementById(
                                `image-wrap${index + 1}`);
                            imageParent.innerHTML = "";
                            imageParent.appendChild(selectImage);
                            MicroModal.close();
                        });
                    });
                });
            });
        }
    </script>
</x-app-layout>
