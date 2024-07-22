<x-mary-modal
    wire:model="createCategoryModal"
    class="backdrop-blur"
>
    <x-slot:title>
        Create New Category
    </x-slot:title>

    <x-mary-form wire:submit="save">

        <div class="w-full">
            <x-mary-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                label="Category Name"
                :value="old('name')"
                wire:model="name"
                required
                autofocus
                autocomplete="name"
            />
        </div>

        <x-slot:actions>
            <x-mary-button
                label="Cancel"
                @click="$wire.createCategoryModal = false"
            />
            <x-mary-button
                label="Create"
                class="btn-primary"
                type="submit"
                spinner="save"
            />
        </x-slot:actions>
    </x-mary-form>

</x-mary-modal>
