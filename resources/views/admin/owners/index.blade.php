<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            オーナー一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 md:p-6">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5mx-auto">
                            <x-flash-message :status="session('status')" />
                            <div class="w-full mx-auto overflow-auto lg:w-2/3">
                                <div class="mb-4 text-right">
                                    <a href="{{ route('admin.owners.create') }}" type="button"
                                        class="px-4 py-2 text-lg text-white bg-indigo-500 border-0 rounded md:px-8 focus:outline-none hover:bg-indigo-600">
                                        新規登録
                                    </a>
                                </div>
                                <table class="w-full mb-12 text-left whitespace-no-wrap table-auto">
                                    <thead>
                                        <tr>
                                            <th
                                                class="py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tl rounded-bl md:px-4 title-font">
                                                名前</th>
                                            <th
                                                class="py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 md:px-4 title-font">
                                                メールアドレス</th>
                                            <th
                                                class="py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 md:px-4 title-font">
                                                作成日</th>
                                            <th
                                                class="py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tr rounded-br md:px-4 title-font">
                                            </th>
                                            <th
                                                class="py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tr rounded-br md:px-4 title-font">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($owners as $owner)
                                            <tr>
                                                <td class="py-3 md:px-4">{{ $owner->name }}</td>
                                                <td class="py-3 md:px-4">{{ $owner->email }}</td>
                                                <td class="py-3 md:px-4">{{ $owner->created_at->diffForHumans() }}
                                                </td>
                                                <td class="py-3 md:px-4">
                                                    <a type="button" href="{{ route('admin.owners.edit', $owner) }}"
                                                        class="px-1 py-1 text-white bg-indigo-400 border-0 rounded md:py-2 md:px-4 focus:outline-none hover:bg-indigo-500">
                                                        編集
                                                    </a>
                                                </td>
                                                <td class="py-3 md:px-4">
                                                    <form action="{{ route('admin.owners.destroy', $owner) }}"
                                                        method="post" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="px-1 py-1 text-white bg-red-400 border-0 rounded md:py-2 md:px-4 focus:outline-none hover:bg-red-500">
                                                            削除
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $owners->links() }}
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/admin/owners/index.js') }}"></script>

</x-app-layout>
