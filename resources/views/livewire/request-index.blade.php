<div>
    {{-- Import the create-request component --}}
    <livewire:create-request @created="$refresh" />
    <livewire:update-request @saved="$refresh" />
    <livewire:delete-request @deleted="$refresh" />

    <x-mary-header
        title="Requests"
        subtitle="Manage requests"
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
            />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button
                class="btn-primary"
                wire:click="search"
                spinner="search"
            >Search</x-mary-button>
            <x-mary-dropdown icon="o-funnel">
            </x-mary-dropdown>
            <x-mary-button
                icon="o-plus"
                class="btn-primary"
                spinner="openCreateRequestModal"
                @click="$wire.openCreateRequestModal"
            />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table
        :headers="$headers"
        :rows="$requests"
        striped
        with-pagination
    >

        {{-- Special `Title` truncated slot --}}
        @scope('cell_title', $request)
            <a
                href="{{ route('single-request', $request->id) }}"
                class="text-blue-600 hover:underline"
            >
                {{ Str::limit($request->title, 15) }}
            </a>
        @endscope

        {{-- Special `role` slot --}}
        @scope('cell_status', $request)
            <div class="flex items-center space-x-2 justify-start w-fit">
                <x-mary-badge
                    class="pb-0.5 text-white font-semibold
   {{ $request->status == 'approved' ? 'bg-emerald-500' : ($request->status == 'pending' ? 'bg-amber-500' : 'bg-rose-600') }}"
                    value="{{ ucfirst($request->status) }}"
                />
            </div>
        @endscope

        {{-- Product name --}}
        @scope('cell_product_id', $request)
            {{ $this->getProductName($request->product_id) }}
        @endscope

        {{-- User name --}}
        @scope('cell_user_id', $request)
            {{ $this->getUserName($request->user_id) }}
        @endscope

        {{-- Special `created_at` slot --}}
        @scope('cell_created_at', $request)
            {{ $request->created_at->format('d/m/Y') }}
        @endscope

        {{-- Special `updated_at` slot --}}
        @scope('cell_updated_at', $request)
            {{ $request->updated_at->format('d/m/Y') }}
        @endscope

        {{-- Special `actions` slot --}}
        @scope('cell_actions', $request)
            <div class="flex items-center space-x-2 justify-end">
                @can('manage-requests')
                    {{-- Employee and Admin can edit and delete their own requests --}}
                    @if ($request->user_id == auth()->user()->id || auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                        <x-mary-button
                            icon="o-pencil-square"
                            wire:click="openUpdateRequestModal({{ $request->id }})"
                            spinner="openUpdateRequestModal({{ $request->id }})"
                            class="btn-sm"
                        />
                        <x-mary-button
                            icon="o-trash"
                            wire:click="openDeleteRequestModal({{ $request->id }})"
                            spinner="openDeleteRequestModal({{ $request->id }})"
                            class="btn-sm bg-red-500 text-white hover:bg-red-600"
                        />
                    @endif
                @endcan

                @can('approve-requests')
                    {{-- Manager and Admin can approve or deny requests --}}
                    @if (
                        (auth()->user()->role === \App\Models\User::ROLE_MANAGER && $request->department == auth()->user()->department) ||
                            auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                        <x-mary-button
                            icon="o-check"
                            wire:click="approveRequest({{ $request->id }})"
                            spinner="approveRequest({{ $request->id }})"
                            class="btn-sm bg-green-500 text-white hover:bg-green-600"
                        />
                        <x-mary-button
                            icon="o-x-circle"
                            wire:click="declineRequest({{ $request->id }})"
                            spinner="declineRequest({{ $request->id }})"
                            class="btn-sm bg-gray-800 text-white hover:bg-gray-900"
                        />
                    @endif
                @endcan
            </div>
        @endscope

    </x-mary-table>
</div>
