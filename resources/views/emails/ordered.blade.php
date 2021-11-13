<p class="mb-4">{{ $product['ownerName'] }}様</p>
<p class="mb-4">下記のご注文ありがとうございました。</p>

<h2>商品情報</h2>
<ul class="mb-4">
    <li>商品名: {{ $product['name'] }}</li>
    <li>商品金額: {{ number_format($product['price']) }}円</li>
    <li>商品数: {{ $product['quantity'] }}</li>
    <li>合計金額: {{ number_format($product['price'] * $product['quantity']) }}</li>
</ul>

<h2>購入者情報</h2>
<ul class="mb-4">
    <li>{{ $user->name }}様</li>
</ul>
