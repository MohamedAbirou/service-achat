<x-mary-modal
    wire:model="updateUserModal"
    class="backdrop-blur"
    title="Update User"
>

    <x-mary-form wire:submit="update">

        <div class="flex items-center space-x-5">
            <div class="w-full">
                <x-mary-input
                    id="first_name"
                    class="block mt-1 w-full"
                    type="text"
                    label="First Name"
                    name="first_name"
                    wire:model.defer="first_name"
                    required
                    autofocus
                    autocomplete="first_name"
                />
            </div>

            <div class="w-full">
                <x-mary-input
                    id="last_name"
                    class="block mt-1 w-full"
                    type="text"
                    label="Last Name"
                    name="last_name"
                    wire:model.defer="last_name"
                    required
                    autofocus
                    autocomplete="last_name"
                />
            </div>
        </div>

        <div>
            <x-mary-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                label="Email"
                name="email"
                wire:model.defer="email"
                required
                autocomplete="username"
            />
        </div>

        <x-slot:actions>
            <x-mary-button
                label="Cancel"
                @click="$wire.updateUserModal = false"
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
