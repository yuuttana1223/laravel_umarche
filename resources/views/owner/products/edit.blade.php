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
                        <x-flash-message :status="session('status')" />
                        @csrf
                        @method('PATCH')
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                                required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                            <textarea type="text" id="information" name="information" required rows="10"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information', $product->information) }}</textarea>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                                required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <h3 class="leading-7 text-sm text-gray-600">現在の在庫</h3>
                            {{-- 楽観的ロック用 --}}
                            <input type="hidden" id="current_quantity" name="current_quantity"
                                value="{{ $quantity }}">
                            <p class="leading-8 py-1 px-3">
                                {{ $quantity }}</p>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="quantity" class="block leading-7 text-sm text-gray-600"></label>
                            <div class="flex justify-between">
                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}"
                                    required
                                    class="w-1/2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200  outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗 ※必須</label>
                            <select name="shop_id" id="shop_id"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 outline-none text-gray-700 py-1 px-3 leading-8">
                                @foreach ($shops as $shop)
                                    <option value="{{ old('shop_id', $shop->id) }}">
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
                        <div class="p-2 w-1/2 mx-auto text-right mb-8">
                            <label class="mr-2">
                                <input type="radio" name="is_selling" value="1" class="mr-1"
                                    {{ old('is_selling', (string) $product->is_selling) === '1' ? 'checked' : '' }}>販売中
                            </label>
                            <label>
                                <input type="radio" name="is_selling" value="0" class="mr-1"
                                    {{ old('is_selling', (string) $product->is_selling) === '0' ? 'checked' : '' }}>停止中
                            </label>
                        </div>
                        <x-select-image-modal :images="$images" />

                        @foreach ($currentImages as $image)
                            <div class="flex justify-around items-center mb-4 h-48">
                                <a data-micromodal-trigger="modal-1" href='javascript:;'
                                    class="md:py-1 md:px-2 bg-gray-200">画像を編集</a>
                                <input type="hidden" name="image{{ $loop->index + 1 }}" @if((is_null(old('image' . $loop->index + 1)))) value="{{ $image->id ?? '' }}" @else value="{{ old('image' . $loop->index + 1) ?? '' }}" @endif>
                                <div class="w-1/4" id="image-wrap{{ $loop->index + 1 }}">
                                    @if (is_null(old('image' . $loop->index + 1)) && isset($image->filename))
                                        <img src="{{ asset("storage/products/{$image->filename}") }}"
                                            alt="{{ $image->title }}" class="border rounded-md p-2 md:p-4 md:pb-6">
                                    @elseif (isset($images[old('image' . $loop->index + 1) - 1]->filename))
                                        <img src="{{ asset('storage/products/' . $images[old('image' . $loop->index + 1) - 1]->filename) }}"
                                            alt="{{ $images[old('image' . $loop->index + 1) - 1]->title }}"
                                            class="border rounded-md p-2 md:p-4 md:pb-6">
                                    @endif
                                </div>
                                <button type="button" class="delete-image md:py-1 md:px-2 bg-red-400">画像を削除</button>
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

            document.querySelectorAll(".delete-image").forEach((deleteImage, index) => {
                deleteImage.addEventListener("click", (e) => {
                    e.target.previousElementSibling.innerHTML = "";
                    document.querySelector(`input[name=image${index + 1}]`).value = "";
                })
            })

            const increaseWord = "現在の在庫から増やす数量";
            const decreaseWord = "現在の在庫から減らす数量"
            const typeButtons = document.querySelectorAll("input[name='type']");
            const quantityLabel = document.querySelector("label[for='quantity']");
            quantityLabel.innerText = (typeButtons[0].checked) ? increaseWord : decreaseWord;
            console.log(typeButtons[0].value);
            typeButtons.forEach((typeButton) => {
                typeButton.addEventListener("click", (e) => {
                    switch (e.target.value) {
                        case "1":
                            quantityLabel.innerText = increaseWord;
                            break;
                        case "2":
                            quantityLabel.innerText = decreaseWord;
                            break;
                    }
                });
            });
        }
    </script>
</x-app-layout>
