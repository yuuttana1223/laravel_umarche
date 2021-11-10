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
                    <x-flash-message :status="session('status')" />
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
                            <form action="{{ route('user.carts.destroy', [Auth::user(), $product->pivot->id]) }}"
                                method="post" class="delete md:w-2/12">
                                @csrf
                                @method('DELETE')
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                    <h2 class="my-2">
                        小計: {{ number_format($totalAmount) }}
                        <span class="text-sm text-gray-700">
                            円(税込)
                        </span>
                    </h2>
                    <div class="text-right">
                        <a href="{{ route('user.carts.checkout', Auth::user()) }}" type="button"
                            class="px-2 py-1 mt-3 text-white bg-indigo-500 border-0 rounded md:py-2 md:px-6 focus:outline-none hover:bg-indigo-600">購入する</a>
                    </div>
                    @if ($products->isEmpty())
                        <h2 class="text-red-500">カートに商品が入っておりません。</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/user/carts/index.js') }}"></script>
</x-app-layout>
