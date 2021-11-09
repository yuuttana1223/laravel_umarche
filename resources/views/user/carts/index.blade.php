<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
            </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <div class="mb-2 md:flex md:items-center">
                                <x-thumbnail filename="{{ $product->imageFirst->filename }}" dirname="products"
                                    alt="{{ $product->name ?? '商品画像' . $loop->index + 1 }}" class="mb-2 md:w-3/12" />
                                <h2 class="mb-2 md:w-4/12 md:ml-2">{{ $product->name }}</h2>
                                <div class="flex justify-around mb-2 md:w-3/12">
                                    <h3>{{ $product->pivot->quantity }}個</h3>
                                    <h3>
                                        {{ number_format($product->pivot->quantity * $product->price) }}
                                        <span class="text-sm text-gray-700">
                                            円(税込)
                                        </span>
                                    </h3>
                                </div>
                                <div class="md:w-2/12">削除ボタン</div>
                            </div>
                        @endforeach
                    @else
                        カートに商品が入っておりません。
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
