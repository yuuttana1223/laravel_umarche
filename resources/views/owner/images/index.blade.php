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
                    <x-flash-message :status="session('status')" />
                    <div class="text-right mb-4">
                        <a href="{{ route('owner.images.create') }}" type="button"
                            class="text-white bg-indigo-500 border-0 py-2 px-4 md:px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            新規登録
                        </a>
                    </div>
                    <div class="flex flex-wrap">
                        @foreach ($images as $image)
                            <div class="p-2 w-1/4">
                                <a href="{{ route('owner.images.edit', $image) }}"
                                    class="block border rounded-md p-2 md:p-4 md:pb-8">
                                    <x-thumbnail :filename="$image->filename" dirname="products" />
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
