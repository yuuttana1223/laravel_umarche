<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('商品の詳細') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:justify-around">
                        <div class="md:w-1/2">
                            <!-- Slider main container -->
                            <div class="swiper">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach ($product->getImages() as $image)
                                        @if (!is_null($image))
                                            <div class="swiper-slide">
                                                <img src="{{ asset("storage/products/{$image->filename}") }}"
                                                    alt="{{ $image->title ?? '商品画像' . $loop->index + 1 }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination"></div>

                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>

                                <!-- If we need scrollbar -->
                                <div class="swiper-scrollbar"></div>
                            </div>
                        </div>
                        <div class="ml-4 md:w-1/2">
                            <h3 class="mt-3 text-sm tracking-widest text-gray-500 title-font">
                                {{ $product->category->name }}
                            </h3>
                            <h2 class="mt-3 mb-1 text-3xl font-medium text-gray-900 title-font">{{ $product->name }}
                            </h2>
                            <p class="mt-3 leading-relaxed">
                                {{ $product->information }}
                            </p>
                            <div class="mt-3 text-center md:flex md:justify-around">
                                <p class="text-2xl font-medium text-gray-900 title-font">
                                    {{ number_format($product->price) }}
                                    <span class="text-sm text-gray-500">円(税込)</span>
                                </p>
                                <div class="md:flex md:items-center md:flex-wrap">
                                    <h3 class="mr-3">数量</h3>
                                    <select
                                        class="py-2 pl-3 pr-10 text-base border border-gray-300 rounded appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 md:block">
                                        <option>SM</option>
                                        <option>M</option>
                                        <option>L</option>
                                        <option>XL</option>
                                    </select>
                                </div>
                                <button
                                    class="px-2 py-1 text-white bg-indigo-500 border-0 rounded md:py-2 md:px-6 focus:outline-none hover:bg-indigo-600 md:block">カートに入れる</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/swiper.js') }}"></script>
</x-app-layout>
