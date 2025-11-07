<div x-data >
    @if ($product ?? false)
        <h2 class="text-xl font-bold mb-2">{{ $product->name }}</h2>
        <p class="text-gray-600">{{ $product->created_at }}</p>
    @else
        <p>Product not found.</p>
    @endif
</div>
