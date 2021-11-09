@if (empty($filename))
    <img {{ $attributes }} src="{{ asset('images/no_image.jpg') }}" alt="画像なし">
@else
    <img {{ $attributes->merge([
        'class' => '',
        'alt' => '画像',
    ]) }}
        src="{{ asset("storage/{$dirname}/{$filename}") }}">
@endif
