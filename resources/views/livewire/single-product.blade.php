<div>
    {{-- Import the manage product components --}}
    <livewire:update-product @saved="$refresh" />
    <livewire:delete-product @deleted="$refresh" />

    <h1 class="text-2xl font-bold">Product Details</h1>

    <div class="mt-4">
        <img
            src="{{ str($product->image)->startsWith('http') ? $product->image : Storage::url($product->image) }}"
            class="w-20"
        />
    </div>

    <div class="mt-4">
        <strong>Name:</strong> {{ $product->name }}
    </div>

    <div class="mt-4">
        <strong>Price:</strong> ${{ $product->price }}
    </div>

    {{-- In stock --}}
    <div class="mt-4 flex items-center space-x-2">
        <strong>In Stock:</strong>
        @if ($product->in_stock)
            <div class="bg-green-300 py-1 pl-2 pr-3 rounded-full flex items-center justify-center w-max">
                <x-heroicon-o-check-badge class="w-5 h-5 mr-1 text-white" />
                <span class="text-white">In Stock</span>
            </div>
        @else
            <div class="bg-red-500 py-1 pl-2 pr-3 rounded-full flex items-center justify-center w-max">
                <x-heroicon-o-x-circle class="w-5 h-5 mr-1 text-white" />
                <span class="text-white">Out Of Stock</span>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
    </div>

    {{-- Created at --}}
    <div class="mt-4">
        <strong>Created At:</strong> {{ $product->created_at->format('d/m/Y') }}
    </div>

    {{-- Updated at --}}
    <div class="mt-4">
        <strong>Updated At:</strong> {{ $product->updated_at->format('d/m/Y') }}
    </div>

    @can('manage-products')
        <div class="mt-4">
            <x-mary-button
                wire:click="openUpdateProductModal({{ $product->id }})"
                spinner="openUpdateProductModal({{ $product->id }})"
                class="btn btn-primary"
            >Edit</x-mary-button>
            <x-mary-button
                wire:click="openDeleteProductModal({{ $product->id }})"
                spinner="openDeleteProductModal({{ $product->id }})"
                class="btn bg-red-500 text-white hover:bg-red-600"
            >Delete</x-mary-button>
        </div>
    @endcan
</div>
