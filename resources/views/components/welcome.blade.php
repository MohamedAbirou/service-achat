<div>
    <div class="shadow-none bg-white dark:bg-gray-800 grid grid-cols-1 md:grid-cols-2 gap-y-20 gap-x-10">

        <x-mary-card class="bg-gray-50 dark:bg-gray-800 border border-sky-100 flex items-center shadow-md">
            <x-slot:title>
                @if ($user->role === 'employee' || $user->role === 'manager')
                    All Requests
                @else
                    Users
                @endif
            </x-slot:title>

            <p class="bg-blue-400 px-5 py-0.5 text-white font-semibold rounded-full text-lg w-fit">
                @if ($user->role === 'employee' || $user->role === 'manager')
                    {{ $user->requests()->count() }}
                @else
                    {{ $users->count() }}
                @endif
            </p>
        </x-mary-card>

        <x-mary-card class=" bg-gray-50 dark:bg-gray-800 border border-emerald-100 flex items-center shadow-md">
            <x-slot:title>
                @if ($user->role === 'employee' || $user->role === 'manager')
                    Approved Requests
                @else
                    Products
                @endif
            </x-slot:title>

            <p class="bg-emerald-400 px-5 py-0.5 text-white font-semibold rounded-full text-lg w-fit">
                @if ($user->role === 'employee' || $user->role === 'manager')
                    {{ $user->requests()->where('status', 'approved')->count() }}
                @else
                    {{ $products->count() }}
                @endif
            </p>
        </x-mary-card>

        <x-mary-card class="bg-gray-50 dark:bg-gray-800 border border-rose-100 flex items-center shadow-md">
            <x-slot:title>
                @if ($user->role === 'employee' || $user->role === 'manager')
                    Declined Requests
                @else
                    Categories
                @endif
            </x-slot:title>
            <p class="bg-rose-400 px-5 py-0.5 text-white font-semibold rounded-full text-lg w-fit capitalize">
                @if ($user->role === 'employee' || $user->role === 'manager')
                    {{ $user->requests()->where('status', 'declined')->count() }}
                @else
                    {{ $categories->count() }}
                @endif
            </p>

        </x-mary-card>

        <x-mary-card class="bg-gray-50 dark:bg-gray-800 border border-amber-100 flex items-center shadow-md">
            <x-slot:title>
                @if ($user->role === 'employee' || $user->role === 'manager')
                    Pending Requests
                @else
                    Requests
                @endif
            </x-slot:title>
            <p class="bg-amber-400 px-5 py-0.5 text-white font-semibold rounded-full text-lg w-fit capitalize">
                @if ($user->role === 'employee' || $user->role === 'manager')
                    {{ $user->requests()->where('status', 'pending')->count() }}
                @else
                    {{ $requests->count() }}
                @endif
            </p>
        </x-mary-card>
    </div>
</div>
