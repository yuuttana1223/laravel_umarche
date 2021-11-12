<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            商品一覧
        </h1>

        <form action="{{ route('user.items.index') }}" method="get" id="select-form" class="my-2">
            <div class="md:text-right">
                <select name="category" class="mb-2">
                    <option value="0" {{ \Request::get('category') === '0' ? 'selected' : '' }}>全て</option>
                    @foreach ($categories as $primaryCategory)
                        <optgroup label="{{ $primaryCategory->name }}">
                            @foreach ($primaryCategory->categories as $secondaryCategory)
                                <option value="{{ $secondaryCategory->id }}"
                                    {{ \Request::get('category') === "$secondaryCategory->id" ? 'selected' : '' }}>
                                    {{ $secondaryCategory->name }}
                                </option>
                            @endforeach
                    @endforeach
                </select>
                <input name="keyword" type="text" placeholder="キーワードを入力" value="{{ \Request::get('keyword') }}"
                    class="py-2 border-gray-500">
                <button
                    class="px-6 py-2 text-white bg-indigo-500 border-0 rounded focus:outline-none hover:bg-indigo-600">検索する</button>
            </div>
            <div class="mt-2 md:flex md:justify-end">
                <div>
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
                </div>
                <div>
                    <span class="text-sm">表示件数</span><br>
                    <select name="pagination" id="pagination">
                        <option value="20" {{ \Request::get('pagination') === '20' ? 'selected' : '' }}>
                            20件
                        </option>
                        <option value="50" {{ \Request::get('pagination') === '50' ? 'selected' : '' }}>
                            50件
                        </option>
                        <option value="100" {{ \Request::get('pagination') === '100' ? 'selected' : '' }}>
                            100件
                        </option>
                    </select>
                </div>
            </div>
        </form>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:flex-wrap">
                        @foreach ($products as $product)
                            <div class="p-2 md:w-1/4">
                                <a href="{{ route('user.items.show', ['item' => $product->id]) }}"
                                    class="block p-2 border rounded-md md:p-4 md:pb-8">
                                    <div class="md:w-60 md:h-36">
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
                    {{ $products->appends([
                            'sort' => \Request::get('sort'),
                            'pagination' => \Request::get('pagination'),
                        ])->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/user/items/index.js') }}"></script>
</x-app-layout>
