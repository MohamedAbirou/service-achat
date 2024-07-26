<x-mary-modal
    wire:model="updateUserModal"
    class="backdrop-blur"
    title="Update User"
>

    <x-mary-form wire:submit="update">

        <div class="flex items-center space-x-5">
            <div class="w-full">
                <x-mary-input
                    class="block mt-1 w-full"
                    type="text"
                    label="First Name"
                    name="first_name"
                    wire:model="first_name"
                    required
                    autofocus
                    autocomplete="first_name"
                />
            </div>

            <div class="w-full">
                <x-mary-input
                    class="block mt-1 w-full"
                    type="text"
                    label="Last Name"
                    name="last_name"
                    wire:model="last_name"
                    required
                    autofocus
                    autocomplete="last_name"
                />
            </div>
        </div>

        <div>
            <x-mary-input
                class="block mt-1 w-full"
                type="email"
                label="Email"
                name="email"
                wire:model="email"
                required
                autocomplete="username"
            />
        </div>

        <div>
            <label
                for="roleUpdate"
                class="block text-sm font-medium text-gray-700"
            >Role <span class="text-red-500">*</span></label>
            <select
                id="roleUpdate"
                name="role"
                wire:model="role"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm outline-indigo-500 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                autocomplete="role"
                required
            >
                <option value="">Select a role</option>
                <option value="employee">Employee</option>
                <option value="manager">Manager</option>
            </select>
        </div>

        <div>
            <label
                for="departmentUpdate"
                class="block text-sm font-medium text-gray-700"
            >Department <span class="text-red-500">*</span></label>
            <select
                id="departmentUpdate"
                name="department"
                wire:model="department"
                autocomplete="department"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required
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
