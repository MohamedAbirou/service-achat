<div>
    {{-- Import the create-category component --}}
    <livewire:create-category @created="$refresh" />
    <livewire:update-category @saved="$refresh" />
    <livewire:delete-category @deleted="$refresh" />

    <x-mary-header
        title="Categories"
        subtitle="Manage categories"
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
            <x-mary-button
                icon="o-plus"
                class="btn-primary"
                spinner="openCreateCategoryModal"
                @click="$wire.openCreateCategoryModal"
            />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table
        :headers="$headers"
        :rows="$categories"
        striped
        :sort-by="$sortBy"
        with-pagination
    >

        {{-- Special `actions` slot --}}
        @scope('cell_actions', $category)
            <div class="flex items-center space-x-2 justify-start w-fit">
                <x-mary-button
                    icon="o-pencil-square"
                    wire:click="openUpdateCategoryModal({{ $category->id }})"
                    spinner="openUpdateCategoryModal({{ $category->id }})"
                    class="btn-sm"
                />
                <x-mary-button
                    icon="o-trash"
                    wire:click="openDeleteCategoryModal({{ $category->id }})"
                    spinner="openDeleteCategoryModal({{ $category->id }})"
                    class="btn-sm bg-red-500 text-white hover:bg-red-600"
                />
            </div>
        @endscope
    </x-mary-table>
</div>
