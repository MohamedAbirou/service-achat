<div>
    {{-- Import the create-request component --}}
    <livewire:create-request @created="$refresh" />
    <livewire:update-request @saved="$refresh" />
    <livewire:delete-request @deleted="$refresh" />
    <livewire:approve-request @approved="$refresh" />
    <livewire:decline-request @declined="$refresh" />

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
                @foreach ($requestFilters as $filter => $isActive)
                    <x-mary-menu-item wire:key="{{ $filter }}">
                        <x-mary-checkbox
                            label="{{ Str::title(str_replace('_', ' ', $filter)) }}"
                            wire:model.live="requestFilters.{{ $filter }}"
                            id="requestFilters[]"
                            :checked="$isActive"
                        />
                    </x-mary-menu-item>
                @endforeach
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
        :sort-by="$sortBy"
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
                    class="text-white font-semibold lowercase pb-0.5
   {{ $request->status == 'approved' ? 'bg-emerald-500' : ($request->status == 'pending' ? 'bg-amber-500' : 'bg-rose-600') }}"
                    value="{{ ucfirst($request->status) }}"
                />
            </div>
        @endscope

        {{-- Department --}}
        @scope('cell_department', $request)
            {{ $request->department ?? 'Unknown' }}
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
                            wire:click="openApproveRequestModal({{ $request->id }})"
                            spinner="openApproveRequestModal({{ $request->id }})"
                            class="btn-sm bg-green-500 text-white hover:bg-green-600"
                        />
                        <x-mary-button
                            icon="o-x-circle"
                            wire:click="openDeclineRequestModal({{ $request->id }})"
                            spinner="openDeclineRequestModal({{ $request->id }})"
                            class="btn-sm bg-gray-800 text-white hover:bg-gray-900"
                        />
                    @endif
                @endcan
            </div>
        @endscope

    </x-mary-table>
</div>
