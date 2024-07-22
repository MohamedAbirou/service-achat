<x-mary-modal
    wire:model="updateCategoryModal"
    class="backdrop-blur"
    title="Update Category"
>

    <x-mary-form wire:submit="update">

        <div class="w-full">
            <x-mary-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                label="Category Name"
                name="name"
                wire:model.defer="name"
                required
                autofocus
                autocomplete="name"
            />
        </div>

        <x-slot:actions>
            <x-mary-button
                label="Cancel"
                @click="$wire.updateCategoryModal = false"
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
