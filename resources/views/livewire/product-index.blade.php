<div>

    {{-- Import the create-user component --}}
    <livewire:create-product @created="$refresh" />
    <livewire:update-product @saved="$refresh" />
    <livewire:delete-product @deleted="$refresh" />


    <x-mary-header
        title="Products"
        subtitle="Manage products"
    >
        <x-slot:middle
            name="middle"
            class="!justify-end"
        >
            <div class="relative">
                <x-mary-input
                    id="query"
                    icon="o-bolt"
                    placeholder="Search..."
                    wire:model="query"
                    class="w-full"
                />
                <x-mary-button
                    class="absolute top-0 right-0 btn-primary"
                    wire:click="search"
                >Search</x-mary-button>
            </div>
        </x-slot:middle>
        <x-slot name="actions">
            <x-mary-dropdown icon="o-funnel">
                {{-- Checkboxed for sorting low to high and high to low, In Stock and Out of Stock, latest and oldest --}}
                <x-mary-menu-item wire:check="sortBy('price', 'asc')">
                    <x-mary-checkbox label="Low to High" />
                </x-mary-menu-item>
                <x-mary-menu-item wire:check="sortBy('price', 'desc')">
                    <x-mary-checkbox label="High to Low" />
                </x-mary-menu-item>
                <x-mary-menu-item wire:check="sortBy('in_stock', 'asc')">
                    <x-mary-checkbox label="In Stock" />
                </x-mary-menu-item>
                <x-mary-menu-item wire:check="sortBy('in_stock', 'desc')">
                    <x-mary-checkbox label="Out Of Stock" />
                </x-mary-menu-item>
                <x-mary-menu-item wire:check="sortBy('created_at', 'asc')">
                    <x-mary-checkbox label="Latest" />
                </x-mary-menu-item>
                <x-mary-menu-item wire:check="sortBy('created_at', 'desc')">
                    <x-mary-checkbox label="Oldest" />
                </x-mary-menu-item>
            </x-mary-dropdown>
            <x-mary-button
                icon="o-plus"
                class="btn-primary"
                spinner="openCreateProductModal"
                @click="$wire.openCreateProductModal"
            />
        </x-slot>
    </x-mary-header>

    <x-mary-table
        :headers="$headers"
        :rows="$products"
        striped
        :sort-by="$sortBy"
        with-pagination
    >

        @scope('cell_image', $product)
            <img
                src="{{ str($product->image)->startsWith('http') ? $product->image : Storage::url($product->image) }}"
                class="w-20"
            />
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

        {{-- Category name --}}
        @scope('cell_category_id', $product)
            {{ $this->getCategoryName($product->category_id) }}
        @endscope

        {{-- In Stock status --}}
        @scope('cell_in_stock', $product)
            @if ($product->in_stock)
                <div class="bg-green-300 py-1 px-2 rounded-full flex items-center justify-center w-[65%]">
                    <x-heroicon-o-check-badge class="w-5 h-5 mr-1 text-white" />
                    <span class="text-white">In Stock</span>
                </div>
            @else
                <div class="bg-red-500 py-1 px-2 rounded-full flex items-center justify-center w-[65%]">
                    <x-heroicon-o-x-circle class="w-5 h-5 mr-1 text-white" />
                    <span class="text-white">Out Of Stock</span>
                </div>
            @endif
        @endscope

        @scope('cell_price', $product)
            @if ($product->price == 0.0)
                <span class="text-red-500">Free</span>
            @else
                {{ $product->price }}
            @endif
        @endscope

    </x-mary-table>

</div>
