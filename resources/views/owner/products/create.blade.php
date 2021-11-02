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
                            <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                            <textarea type="text" id="information" name="information" required rows="10"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information') }}</textarea>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫数 ※必須</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
                            <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー ※必須</label>
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
                        <div class="p-2 w-1/2 mx-auto text-right mb-8">
                            <label class="mr-2">
                                <input type="radio" name="is_selling" value="{{ old('is_selling') }}"
                                    class="mr-1" checked>販売中
                            </label>
                            <label>
                                <input type="radio" name="is_selling" value="{{ old('is_selling') }}"
                                    class="mr-1">停止中
                            </label>
                        </div>
                        <x-select-image-modal :images="$images" />
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="flex justify-around items-center mb-4 h-48">
                                <a data-micromodal-trigger="modal-1" href='javascript:;'
                                    class="md:py-1 md:px-2 bg-gray-200">画像を選択</a>
                                <input type="hidden" name="{{ "image$i" }}">
                                <div class="w-1/4" id="image-wrap{{ $i }}">
                                </div>
                            </div>
                        @endfor
                </div>
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
            const selectButtons = document.querySelectorAll("a[href='javascript:;']");

            selectButtons.forEach((selectBtn, index) => {
                selectBtn.addEventListener("click", (e) => {
                    const input = e.target.nextElementSibling
                    // モーダル出現
                    document.querySelectorAll(".image").forEach((modalImage) => {
                        // イベントを上書き(addEventListenerだと無限にイベントが追加されていく)
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
