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
                    <x-mary-input
                        id="first_name"
                        class="block mt-1 w-full"
                        type="text"
                        label="First Name"
                        name="first_name"
                        :value="old('first_name')"
                        wire:model="first_name"
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
                        :value="old('last_name')"
                        wire:model="last_name"
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
                    name="email"
                    label="Email"
                    :value="old('email')"
                    wire:model="email"
                    required
                    autocomplete="username"
                />
            </div>

            <div>
                <x-mary-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    label="Password"
                    wire:model="password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div>
                <x-mary-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    label="Confirm Password"
                    wire:model="password_confirmation"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div>
                <label
                    for="role"
                    class="block text-sm font-medium text-gray-700"
                >Role <span class="text-red-500">*</span></label>
                <select
                    id="role"
                    name="role"
                    wire:model="role"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm outline-indigo-500 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required
                >
                    <option value="">Select a role</option>
                    <option value="employee">Employee</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <div>
                <label
                    for="department"
                    class="block text-sm font-medium text-gray-700"
                >Department</label>
                <select
                    id="department"
                    name="department"
                    wire:model="department"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                    <option value="">Select a department</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
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
