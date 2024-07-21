<div>

    <h1>Request Details</h1>

    <div>
        <strong>Title:</strong> {{ $request->title }}
    </div>
    <div>
        <strong>Description:</strong> {{ $request->description }}
    </div>
    <div>
        <strong>Quantity:</strong> {{ $request->quantity }}
    </div>
    <div>
        <strong>Budget:</strong> {{ $request->budget }}
    </div>
    <div>
        <strong>Status:</strong>
        <x-mary-badge
            class="pb-0.5 text-white font-semibold
   {{ $request->status == 'approved' ? 'bg-emerald-500' : ($request->status == 'pending' ? 'bg-amber-500' : 'bg-rose-600') }}"
            value="{{ ucfirst($request->status) }}"
        />
    </div>
    <div>
        <strong>Department:</strong> {{ $request->department }}
    </div>
    <div>
        <strong>Product:</strong> <a
            href="/products/{{ $request->product_id }}"
            class="text-blue-600 hover:underline"
        >{{ $request->product->name ?? 'N/A' }}</a>
    </div>
    <div>
        <strong>User:</strong> {{ $request->user->first_name }} {{ $request->user->last_name }}
    </div>

    @can('approve-requests')
        @if ($request->status == 'pending')
            <div class="mt-4">
                <x-mary-button
                    wire:click="approveRequest"
                    class="btn btn-success text-white"
                    spinner="approveRequest"
                >Approve</x-mary-button>
                <x-mary-button
                    wire:click="declineRequest"
                    class="btn bg-red-500 text-white hover:bg-red-600"
                    spinner="declineRequest"
                >Decline</x-mary-button>
            </div>
        @elseif ($request->status == 'approved')
            <div class="mt-4">
                <x-mary-button
                    wire:click="declineRequest"
                    class="btn bg-red-500 text-white hover:bg-red-600"
                    spinner="declineRequest"
                >Decline</x-mary-button>
            </div>
        @else
            <div class="mt-4">
                <x-mary-button
                    wire:click="approveRequest"
                    class="btn btn-success text-white"
                    spinner="approveRequest"
                >Approve</x-mary-button>
            </div>
        @endif
    @endcan
</div>
