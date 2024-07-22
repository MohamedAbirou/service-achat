<div>
    {{-- Import the manage product components --}}
    <livewire:create-product @created="$refresh" />
    <livewire:update-product @saved="$refresh" />
    <livewire:delete-product @deleted="$refresh" />

    <x-mary-header
        title="Products"
        subtitle="Manage products"
    >
        <x-slot:middle
            class="!justify-end"
        >
            {{-- Search --}}
            <x-mary-input
                id="query"
                icon="o-bolt"
                placeholder="Search..."
                wire:model="query"
                class="w-full"
                wire:keydown.enter="search"
            />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button
                class="btn-primary"
                wire:click="search"
                spinner="search"
            >Search</x-mary-button>
            <x-mary-dropdown icon="o-funnel">
                @foreach ($filters as $filter => $isActive)
                    <x-mary-menu-item wire:key="{{ $filter }}">
                        <x-mary-checkbox
                            label="{{ Str::title(str_replace('_', ' ', $filter)) }}"
                            wire:model.live="filters.{{ $filter }}"
                            id="filters[]"
                            :checked="$isActive"
                        />
                    </x-mary-menu-item>
                @endforeach
            </x-mary-dropdown>
            <x-mary-button
                icon="o-plus"
                class="btn-primary"
                spinner="openCreateProductModal"
                @click="$wire.openCreateProductModal"
            />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table
        :headers="$headers"
        :rows="$products"
        striped
        :sort-by="$sortBy"
        with-pagination
    >

        {{-- Special `name` slot --}}
        @scope('cell_name', $product)
            <a
                href="{{ route('single-product', $product->id) }}"
                class="text-blue-600 hover:underline"
            >
                {{ $product->name }}
            </a>
        @endscope

        {{-- Special `image` slot --}}
        @scope('cell_image', $product)
            <img
                src="{{ str($product->image)->startsWith('http') ? $product->image : Storage::url($product->image) }}"
                class="w-20"
            />
        @endscope

        {{-- Category name --}}
        @scope('cell_category_id', $product)
            {{ $this->getCategoryName($product->category_id) }}
        @endscope

        {{-- In Stock status --}}
        @scope('cell_in_stock', $product)
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
        @endscope

        {{-- Special `price` slot --}}
        @scope('cell_price', $product)
            @if ($product->price == 0.0)
                <span class="text-red-500">Free</span>
            @else
                {{ $product->price }}
            @endif
        @endscope

        {{-- Special `actions` slot --}}
        @scope('cell_actions', $product)
            <div class="flex items-center space-x-2 justify-start w-fit">
                <x-mary-button
                    icon="o-pencil-square"
                    wire:click="openUpdateProductModal({{ $product->id }})"
                    spinner="openUpdateProductModal({{ $product->id }})"
                    class="btn-sm"
                />
                <x-mary-button
                    icon="o-trash"
                    wire:click="openDeleteProductModal({{ $product->id }})"
                    spinner="openDeleteProductModal({{ $product->id }})"
                    class="btn-sm bg-red-500 text-white hover:bg-red-600"
                />
            </div>
        @endscope
    </x-mary-table>
</div>
