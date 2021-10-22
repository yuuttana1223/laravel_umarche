@props(['status' => 'info'])
@php
if ($status === 'info') {
    $bgColor = 'bg-blue-300';
} elseif ($status === 'error') {
    $bgColor = 'bg-red-500';
}
@endphp
@if (session('message'))
    <div class="{{ $bgColor }} w-1/2 mx-auto mb-4 p-2 text-white">
        {{ session('message') }} </div>
@endif
