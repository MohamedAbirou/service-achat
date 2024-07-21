<div>
    <x-mary-modal
        wire:model="updateRequestModal"
        class="backdrop-blur"
    >
        <x-slot:title>
            Update Request
        </x-slot:title>

        <x-validation-errors class="mb-4" />

        <x-mary-form wire:submit.prevent="update">
            <div>
                <x-mary-input
                    id="title"
                    type="text"
                    label="Title"
                    name="title"
                    wire:model.defer="title"
                    required
                    autofocus
                    autocomplete="title"
                />
            </div>

            <div>
                <x-mary-textarea
                    label="Description"
                    name="description"
                    wire:model="description"
                    placeholder="Your request description ..."
                    hint="Max 500 chars"
                    rows="5"
                    inline
                    autofocus
                    autocomplete="description"
                />
            </div>

            <div>
                <x-mary-input
                    id="quantity"
                    type="number"
                    label="Quantity"
                    name="quantity"
                    step="1"
                    wire:model.defer="quantity"
                    required
                    autofocus
                    autocomplete="quantity"
                />
            </div>

            <div>
                <x-mary-input
                    id="budget"
                    type="number"
                    label="Budget"
                    name="budget"
                    step="10"
                    wire:model.defer="budget"
                    required
                    autofocus
                    autocomplete="budget"
                />
            </div>

            <div>
                <x-mary-select
                    id="product_id"
                    name="product_id"
                    label="Product"
                    wire:model="product_id"
                    :options="$products"
                    required
                />
            </div>

            <x-slot name="actions">
                <x-mary-button
                    label="Cancel"
                    @click="$wire.updateRequestModal = false"
                />
                <x-mary-button
                    label="Update"
                    type="submit"
                    class="btn-primary"
                    spinner="update"
                />
            </x-slot>
        </x-mary-form>

    </x-mary-modal>
</div>
