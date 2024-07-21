<div>
    <x-mary-modal
        wire:model="createRequestModal"
        class="backdrop-blur"
    >
        <x-slot:title>
            Create New Request
        </x-slot:title>

        <x-validation-errors class="mb-4" />

        <x-mary-form wire:submit.prevent="save">
            <div>
                <x-mary-input
                    id="title"
                    type="text"
                    label="Title"
                    wire:model.defer="title"
                    required
                />
            </div>

            <div>
                <x-mary-textarea
                    label="Description"
                    wire:model="description"
                    placeholder="Your request description ..."
                    hint="Max 500 chars"
                    rows="5"
                    inline
                />
            </div>

            <div>
                <x-mary-input
                    id="quantity"
                    type="number"
                    label="Quantity"
                    step="1"
                    wire:model.defer="quantity"
                    required
                />
            </div>

            <div>
                <x-mary-input
                    id="budget"
                    type="number"
                    label="Budget"
                    step="10"
                    wire:model.defer="budget"
                    required
                />
            </div>

            <div>
                <x-mary-select
                    id="product_id"
                    label="Product"
                    wire:model="product_id"
                    :options="$products"
                    required
                />
            </div>

            <x-slot name="actions">
                <x-mary-button
                    label="Cancel"
                    @click="$wire.createRequestModal = false"
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
