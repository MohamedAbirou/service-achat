<div class="container mx-auto px-4 py-8">
    <livewire:request.update-request @saved="$refresh" />
    <livewire:request.delete-request @deleted="$refresh" />

    <!-- User Profile Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
        </div>
    </div>

    <!-- User Details Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">User Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <x-mary-card class="bg-white dark:bg-gray-800 shadow-lg flex items-center">
                <x-slot:title>
                    Role
                </x-slot:title>

                <p
                    class="bg-{{ ($user->role == 'employee' ? 'emerald-500' : $user->role == 'manager') ? 'amber-500' : 'rose-600 ' }} px-5 py-0.5 text-white font-semibold rounded-full text-lg w-fit capitalize">
                    {{ $user->role }}
                </p>
            </x-mary-card>

            <x-mary-card class="bg-white dark:bg-gray-800 shadow-lg flex items-center">
                <x-slot:title>
                    Department
                </x-slot:title>

                <p class="bg-gray-400 px-5 py-0.5 text-white font-semibold rounded-full text-lg w-fit capitalize">
                    {{ $user->department ?? 'Unknown' }}
                </p>
            </x-mary-card>

            <x-mary-card class="bg-white dark:bg-gray-800 shadow-lg flex items-center">
                <x-slot:title>
                    Created At
                </x-slot:title>
                <p>{{ $user->created_at->format('M d, Y') }}</p>

            </x-mary-card>

            <x-mary-card class="bg-white dark:bg-gray-800 shadow-lg flex items-center">
                <x-slot:title>
                    Updated At
                </x-slot:title>
                <p>{{ $user->updated_at->format('M d, Y') }}</p>
            </x-mary-card>
        </div>
    </div>

    <!-- User Requests Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">User Requests</h2>
        @if ($user->requests()->count() === 0)
            <p class="mt-4 text-gray-600 dark:text-gray-400">No requests found for this user.</p>
        @else
            <x-mary-table
                :headers="[
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'status', 'label' => 'Status'],
                    ['key' => 'created_at', 'label' => 'Created At'],
                    ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
                ]"
                :rows="$user->requests->sortByDesc('created_at')"
                striped
                class="dark:text-gray-200"
            >
                @scope('cell_id', $request)
                    <p class="text-sm text-gray-900 dark:text-gray-200">{{ $request->id }}</p>
                @endscope

                @scope('cell_title', $request)
                    <p class="text-sm text-gray-900 dark:text-gray-200">{{ $request->title }}</p>
                @endscope

                @scope('cell_status', $request)
                    <x-mary-badge
                        class="text-white font-semibold lowercase {{ $request->status == 'approved' ? 'bg-green-500' : ($request->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}"
                        value="{{ ucfirst($request->status) }}"
                    />
                @endscope

                @scope('cell_created_at', $request)
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $request->created_at->format('M d, Y') }}</p>
                @endscope

                @scope('cell_actions', $request)
                    <div class="flex items-center space-x-2">
                        <a
                            href="{{ route('single-request', $request->id) }}"
                            class="btn-sm"
                        >
                            <x-mary-button
                                icon="o-eye"
                                class="btn-sm"
                                label="View"
                            />
                        </a>
                        <x-mary-button
                            icon="o-pencil"
                            class="btn-sm"
                            label="Edit"
                            wire:click="openUpdateRequestModal({{ $request->id }})"
                            spinner="openUpdateRequestModal({{ $request->id }})"
                        />
                        <x-mary-button
                            icon="o-trash"
                            class="btn-sm bg-red-500 text-white hover:bg-red-600"
                            label="Delete"
                            wire:click="openDeleteRequestModal({{ $request->id }})"
                            spinner="openDeleteRequestModal({{ $request->id }})"
                        />
                    </div>
                @endscope
            </x-mary-table>
        @endif
    </div>
</div>
