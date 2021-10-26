<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5mx-auto">
                            <x-flash-message :status="session('status')" />
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <div class="text-right mb-4">
                                    <a href="{{ route('admin.owners.create') }}" type="button"
                                        class="text-white bg-indigo-500 border-0 py-2 px-4 md:px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                        新規登録
                                    </a>
                                </div>
                                <table class="table-auto w-full text-left whitespace-no-wrap mb-12">
                                    <thead>
                                        <tr>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                名前</th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                メールアドレス</th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                作成日</th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                            </th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($owners as $owner)
                                            <tr>
                                                <td class="md:px-4 py-3">{{ $owner->name }}</td>
                                                <td class="md:px-4 py-3">{{ $owner->email }}</td>
                                                <td class="md:px-4 py-3">{{ $owner->created_at->diffForHumans() }}
                                                </td>
                                                <td class="md:px-4 py-3">
                                                    <a type="button" href="{{ route('admin.owners.edit', $owner) }}"
                                                        class="text-white bg-indigo-400 border-0 py-1 md:py-2 px-1 md:px-4 focus:outline-none hover:bg-indigo-500 rounded">
                                                        編集
                                                    </a>
                                                </td>
                                                <td class="md:px-4 py-3">
                                                    <form action="{{ route('admin.owners.destroy', $owner) }}"
                                                        method="post" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="
                                                            text-white bg-red-400 border-0 py-1 md:py-2 px-1 md:px-4 focus:outline-none hover:bg-red-500 rounded">
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
    <script>
        "use strict";

        {
            const deleteForms = document.querySelectorAll(".delete-form");
            deleteForms.forEach((deleteForm) => {
                deleteForm.addEventListener("submit", (e) => {
                    e.preventDefault();
                    if (!confirm("本当に削除してもいいですか?")) {
                        return;
                    }
                    deleteForm.submit();
                })
            });
        }
    </script>

</x-app-layout>
