<div>
    <livewire:approve-request @approved="$refresh" />
    <livewire:decline-request @declined="$refresh" />

    <h1 class="tex-2xl font-bold">Request Details</h1>

    <div class="mt-4">
        <strong>Title:</strong> {{ $request->title }}
    </div>
    <div class="mt-4">
        <strong>Description:</strong> {{ $request->description }}
    </div>
    <div class="mt-4">
        <strong>Quantity:</strong> {{ $request->quantity }}
    </div>
    <div class="mt-4">
        <strong>Budget:</strong> {{ $request->budget }}
    </div>
    <div class="mt-4">
        <strong>Status:</strong>
        <x-mary-badge
            class="pb-0.5 text-white font-semibold lowercase
   {{ $request->status == 'approved' ? 'bg-emerald-500' : ($request->status == 'pending' ? 'bg-amber-500' : 'bg-rose-600') }}"
            value="{{ ucfirst($request->status) }}"
        />
    </div>
    <div class="mt-4">
        <strong>Department:</strong> {{ $request->department }}
    </div>
    <div class="mt-4">
        <strong>Product:</strong> <a
            href="/products/{{ $request->product_id }}"
            class="text-blue-600 hover:underline"
        >{{ $request->product->name ?? 'N/A' }}</a>
    </div>
    <div class="mt-4">
        <strong>User:</strong> {{ $request->user->first_name }} {{ $request->user->last_name }}
    </div>

    @can('approve-requests')
        @if ($request->status == 'pending')
            <div class="mt-4">
                <x-mary-button
                    class="btn btn-success text-white"
                    wire:click="openApproveRequestModal({{ $request->id }})"
                    spinner="openApproveRequestModal({{ $request->id }})"
                >Approve</x-mary-button>
                <x-mary-button
                    class="btn bg-red-500 text-white hover:bg-red-600"
                    wire:click="openDeclineRequestModal({{ $request->id }})"
                    spinner="openDeclineRequestModal({{ $request->id }})"
                >Decline</x-mary-button>
            </div>
        @elseif ($request->status == 'approved')
            <div class="mt-4">
                <x-mary-button
                    class="btn bg-red-500 text-white hover:bg-red-600"
                    wire:click="openDeclineRequestModal({{ $request->id }})"
                    spinner="openDeclineRequestModal({{ $request->id }})"
                >Decline</x-mary-button>
            </div>
        @else
            <div class="mt-4">
                <x-mary-button
                    class="btn btn-success text-white"
                    wire:click="openApproveRequestModal({{ $request->id }})"
                    spinner="openApproveRequestModal({{ $request->id }})"
                >Approve</x-mary-button>
            </div>
        @endif
    @endcan
</div>
