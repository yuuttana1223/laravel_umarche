<div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="text-xl text-gray-700" id="modal-1-title">
                    画像を選択してください
                </h2>
                <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <div class="flex flex-wrap">
                    @foreach ($images as $image)
                        <div class="p-2 w-1/4">
                            <img class="image cursor-pointer hover:opacity-80 border rounded-md p-2 md:p-4 md:pb-8"
                                data-id="{{ $image->id }}" src="{{ asset("storage/products/{$image->filename}") }}"
                                alt="{{ $image->title }}" />
                        </div>
                    @endforeach
                </div>
            </main>
            <footer class="modal__footer">
                <button type="button" class="modal__btn" data-micromodal-close aria-label="閉じる">閉じる</button>
            </footer>
        </div>
    </div>
</div>
