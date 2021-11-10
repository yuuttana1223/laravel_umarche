<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-flash-message :status="session('status')" />
                    <div class="mb-4 text-right">
                        <a href="{{ route('owner.images.create') }}" type="button"
                            class="px-4 py-2 text-lg text-white bg-indigo-500 border-0 rounded md:px-8 focus:outline-none hover:bg-indigo-600">
                            新規登録
                        </a>
                    </div>
                    <div class="flex flex-wrap">
                        @foreach ($images as $image)
                            <div class="w-1/4 p-2">
                                <a href="{{ route('owner.images.edit', $image) }}"
                                    class="block p-2 border rounded-md md:p-4 md:pb-8">
                                    <x-thumbnail :filename="$image->filename" dirname="products"
                                        alt="{{ $image->title ?? '' }}" />
                                    <h3 class="text-gray-700">{{ $image->title }}</h3>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
