@if (empty($filename))
    <img src="{{ asset('images/no_image.jpg') }}" alt="商品画像なし">
@else
    <img src="{{ asset("storage/{$dirname}/{$filename}") }}" alt="商品の画像">
@endif
