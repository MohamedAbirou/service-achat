<x-mary-modal
    wire:model="updateProductModal"
    class="backdrop-blur"
    title="Update Product"
>

    <x-mary-form wire:submit="update">
        <div>
            <x-label
                for="name"
                value="{{ __('Name') }}"
            />
            <x-mary-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                wire:model.defer="name"
                required
                autofocus
                autocomplete="name"
            />
        </div>

        <div>
            <x-label
                for="price"
                value="{{ __('Price') }}"
            />
            <x-mary-input
                id="price"
                class="block mt-1 w-full"
                type="number"
                name="price"
                step="0.01"
                wire:model.defer="price"
                required
                autofocus
                autocomplete="price"
            />
        </div>

        <div>
            <x-mary-file
                wire:model="image"
                label="Image"
                accept="image/png, image/jpeg"
            >
                <img
                    src="{{ $image ? asset($image) : 'https://via.placeholder.com/150' }}"
                    class="h-20 rounded-lg"
                />
            </x-mary-file>
        </div>

        <div>
            <x-label
                for="category_id"
                value="Category"
            />
            <x-mary-select
                id="category_id"
                name="category_id"
                wire:model.defer="category_id"
                :options="$categories"
                required
            />
        </div>

        <div>
            <x-label
                for="in_stock"
                value="In Stock"
            />
            <x-mary-checkbox
                id="in_stock"
                label="In Stock"
                wire:model.defer="in_stock"
            />
        </div>

        <x-slot:actions>
            <x-mary-button
                label="Cancel"
                @click="$wire.updateProductModal = false"
            />
            <x-mary-button
                label="Update"
                class="btn-primary"
                type="submit"
                spinner="update"
            />
        </x-slot:actions>
    </x-mary-form>

</x-mary-modal>
