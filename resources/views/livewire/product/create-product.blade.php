<div>
    <x-mary-modal
        wire:model="createProductModal"
        class="backdrop-blur"
    >
        <x-slot:title>
            Create New Product
        </x-slot:title>

        <x-validation-errors class="mb-4" />

        <x-mary-form wire:submit="save">
            <div>
                <x-mary-input
                    id="name"
                    type="text"
                    label="Product Name"
                    wire:model.defer="name"
                    required
                />
            </div>

            <div>
                <x-mary-input
                    id="price"
                    type="number"
                    label="Price"
                    step="0.01"
                    min="0"
                    wire:model.defer="price"
                    required
                />
            </div>

            <div>
                <x-mary-file
                    wire:model.defer="image"
                    label="Image"
                    accept="image/png, image/jpeg"
                />
            </div>

            <div>
                <x-mary-select
                    id="category_id"
                    label="Category"
                    wire:model.defer="category_id"
                    :options="$categories"
                    required
                />
            </div>

            <div>
                <x-mary-checkbox
                    id="in_stock"
                    label="In Stock"
                    wire:model.defer="in_stock"
                />
            </div>

            <x-slot name="actions">
                <x-mary-button
                    label="Cancel"
                    @click="$wire.createProductModal = false"
                />
                <x-mary-button
                    label="Create"
                    type="submit"
                    class="btn-primary"
                    spinner="save"
                />
            </x-slot>
        </x-mary-form>

    </x-mary-modal>
</div>
