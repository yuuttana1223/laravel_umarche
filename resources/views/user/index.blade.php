<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('ホーム') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap">
                        @foreach ($products as $product)
                            <div class="w-1/4 p-2">
                                <a href="{{ route('user.items.show', ['item' => $product->id]) }}"
                                    class="block p-2 border rounded-md md:p-4 md:pb-8">
                                    <x-thumbnail filename="{{ $product->filename ?? '' }}" dirname="products" />
                                    <div class="mt-4">
                                        <h3 class="mb-1 text-xs tracking-widest text-gray-500 title-font">
                                            {{ $product->categoryName }}</h3>
                                        <h2 class="text-lg font-medium text-gray-900 title-font">{{ $product->name }}
                                        </h2>
                                        <p class="mt-1">{{ number_format($product->price) }}<span
                                                class="text-sm text-gray-700">円(税込)</span></p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
