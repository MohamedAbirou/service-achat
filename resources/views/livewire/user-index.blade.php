<div>
    {{-- Import the create-user component --}}
    <livewire:create-user @created="$refresh" />
    <livewire:update-user @saved="$refresh" />
    <livewire:delete-user @deleted="$refresh" />

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
                wire:model.debounce.300ms="query"
            />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" />
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

        {{-- Special `actions` slot --}}
        @scope('cell_actions', $user)
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
        @endscope
    </x-mary-table>
</div>
