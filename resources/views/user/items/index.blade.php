<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="text-xl font-semibold leading-tight text-gray-800">
                商品一覧
            </h1>
            <form action="{{ route('user.items.index') }}" method="get" id="sort-form">
                @csrf
                <span class="text-sm">表示順</span><br>
                <select name="sort" id="sort" class="mr-4">
                    <option value="{{ \ProductConstant::NEWER }}"
                        {{ \Request::get('sort') === \ProductConstant::NEWER ? 'selected' : '' }}>新しい順</option>
                    <option value="{{ \ProductConstant::OLDER }}"
                        {{ \Request::get('sort') === \ProductConstant::OLDER ? 'selected' : '' }}>古い順</option>
                    <option value="{{ \ProductConstant::CHEAPER }}"
                        {{ \Request::get('sort') === \ProductConstant::CHEAPER ? 'selected' : '' }}>安い順</option>
                    <option value="{{ \ProductConstant::HIGHER }}"
                        {{ \Request::get('sort') === \ProductConstant::HIGHER ? 'selected' : '' }}>高い順</option>
                </select>
                <span>表示件数</span>
            </form>
        </div>
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
                                    <div class="w-60 h-36">
                                        <x-thumbnail filename="{{ $product->filename ?? '' }}" dirname="products"
                                            alt="{{ $product->name }}" />
                                    </div>
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
    <script src="{{ asset('js/user/items/index.js') }}"></script>
</x-app-layout>
