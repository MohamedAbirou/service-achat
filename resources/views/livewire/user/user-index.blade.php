<div>
    {{-- Import the create-user component --}}
    <livewire:user.create-user @created="$refresh" />
    <livewire:user.update-user @saved="$refresh" />
    <livewire:user.delete-user @deleted="$refresh" />

    <x-mary-header
        title="Users"
        subtitle="Manage users"
    >
        <x-slot:middle
            class="!justify-end"
        >
            {{-- Search --}}
            <x-mary-input
                id="query"
                icon="o-bolt"
                placeholder="Search..."
                wire:model="query"
                class="w-full"
                wire:keydown.enter="search"
            />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button
                class="btn-primary"
                wire:click="search"
                spinner="search"
            >Search</x-mary-button>
            <x-mary-dropdown icon="o-funnel">
                @foreach ($departments as $department)
                    <x-mary-menu-item wire:key="{{ $department }}">
                        <x-mary-checkbox
                            label="{{ $department }}"
                            id="{{ $department }}"
                            :checked="in_array($department, $filters['department'])"
                            wire:click="updateDepartmentFilter('{{ $department }}')"
                        />

                    </x-mary-menu-item>
                @endforeach
            </x-mary-dropdown>
            <x-mary-button
                icon="o-plus"
                class="btn-primary"
                spinner="openCreateUserModal"
                @click="$wire.openCreateUserModal"
            />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table
        :headers="$headers"
        :rows="$users"
        striped
        :sort-by="$sortBy"
        with-pagination
    >

        {{-- Special `first_name` slot --}}
        @scope('cell_first_name', $user)
            <a
                href="{{ route('user-profile', $user->id) }}"
                class="flex flex-col hover:underline"
            >
                <p class="text-sm font-medium text-gray-900">{{ $user->first_name }}</p>
                <p class="text-sm text-gray-500">{{ $user->last_name }}</p>
            </a>
        @endscope

        @scope('cell_department', $user)
            {{ $user->department ?? 'Unknown' }}
        @endscope

        {{-- Special `role` slot --}}
        @scope('cell_role', $user)
            <div class="flex items-center space-x-2 justify-start w-fit">
                <x-mary-badge
                    class="pb-0.5 text-white font-semibold
           {{ $user->role == 'employee' ? 'bg-emerald-500' : ($user->role == 'manager' ? 'bg-amber-500' : 'bg-rose-600') }}"
                    value="{{ ucfirst($user->role) }}"
                />
            </div>
        @endscope

        {{-- Special `actions` slot --}}
        @scope('cell_actions', $user)
            @if ($user->id !== auth()->user()->id)
                <div class="flex items-center space-x-2 justify-start w-fit">
                    <x-mary-button
                        icon="o-pencil-square"
                        wire:click="openUpdateUserModal({{ $user->id }})"
                        spinner="openUpdateUserModal({{ $user->id }})"
                        class="btn-sm"
                    />
                    <x-mary-button
                        icon="o-trash"
                        wire:click="openDeleteUserModal({{ $user->id }})"
                        spinner="openDeleteUserModal({{ $user->id }})"
                        class="btn-sm bg-red-500 text-white hover:bg-red-600"
                    />
                </div>
            @else
                <p class="font-semibold text-sm">No actions available.</p>
            @endif
        @endscope
    </x-mary-table>
</div>
