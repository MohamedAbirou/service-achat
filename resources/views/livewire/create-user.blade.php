    <x-mary-modal
        wire:model="createUserModal"
        class="backdrop-blur"
    >
        <x-slot:title>
            Create New User
        </x-slot:title>

        <x-mary-form wire:submit="save">
            <div class="flex items-center space-x-5">
                <div class="w-full">
                    <x-label
                        for="first_name"
                        value="{{ __('First Name') }}"
                    />
                    <x-mary-input
                        id="first_name"
                        class="block mt-1 w-full"
                        type="text"
                        name="first_name"
                        :value="old('first_name')"
                        wire:model="first_name"
                        required
                        autofocus
                        autocomplete="first_name"
                    />
                </div>

                <div class="w-full">
                    <x-label
                        for="last_name"
                        value="{{ __('Last Name') }}"
                    />

                    <x-mary-input
                        id="last_name"
                        class="block mt-1 w-full"
                        type="text"
                        name="last_name"
                        :value="old('last_name')"
                        wire:model="last_name"
                        required
                        autofocus
                        autocomplete="last_name"
                    />
                </div>
            </div>

            <div>
                <x-label
                    for="email"
                    value="{{ __('Email') }}"
                />
                <x-mary-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    wire:model="email"
                    required
                    autocomplete="username"
                />
            </div>

            <div>
                <x-label
                    for="password"
                    value="{{ __('Password') }}"
                />
                <x-mary-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    wire:model="password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div>
                <x-label
                    for="password_confirmation"
                    value="{{ __('Confirm Password') }}"
                />
                <x-mary-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    wire:model="password_confirmation"
                    required
                    autocomplete="new-password"
                />
            </div>

            <x-slot:actions>
                <x-mary-button
                    label="Cancel"
                    @click="$wire.createUserModal = false"
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
