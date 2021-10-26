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
                    @foreach ($shops as $shop)
                        <a href="{{ route('owner.shops.edit', $shop) }}"
                            class="block border w-1/2 rounded-md p-4 pb-8">
                            @if ($shop->is_selling)
                                <span class="inline-block border p-2 rounded-md bg-blue-400 text-white">販売中</span>
                            @else
                                <span class="inline-block border p-2 rounded-md bg-red-400 text-white">停止中</span>
                            @endif
                            <h3 class="text-xl my-2">{{ $shop->name }}</h3>
                            @if (empty($shop->filezname))
                                <img src="{{ asset('images/no_image.jpg') }}" alt="商品画像なし">
                            @else
                                <img src="{{ asset("storage/shops/{$shop->filename}") }}" alt="商品の画像">
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
