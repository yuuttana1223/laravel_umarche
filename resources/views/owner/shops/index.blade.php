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
                    @foreach ($shops as $shop)
                        <a href="{{ route('owner.shops.edit', $shop) }}"
                            class="block w-1/2 p-4 pb-8 border rounded-md">
                            @if ($shop->is_selling)
                                <span class="inline-block p-2 text-white bg-blue-400 border rounded-md">販売中</span>
                            @else
                                <span class="inline-block p-2 text-white bg-red-400 border rounded-md">停止中</span>
                            @endif
                            <h3 class="my-2 text-xl">{{ $shop->name }}</h3>
                            <x-thumbnail :filename="$shop->filename" dirname="shops" alt="{{ $shop->name }}" />
                            <p class="mt-2 overflow-y-scroll max-h-50">{!! nl2br(e($shop->information)) !!}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
