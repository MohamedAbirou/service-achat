<!DOCTYPE html>
<html
    lang="en"
    data-theme="light"
>

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>ADSGLORY Service Achat</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased">

    {{-- The navbar with `sticky` and `full-width` --}}
    <x-mary-nav
        sticky
        full-width
    >

        <x-slot:brand>

            {{-- Brand --}}
            <a
                href="{{ route('dashboard') }}"
                class="font-bold"
            >ADSGLORY Service Achat</a>

        </x-slot:brand>



        {{-- Right side actions --}}
        <x-slot:actions>
            <x-mary-theme-toggle
                tooltip-left="switch-theme"
                class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-900 p-3.5 rounded-full"
            />
            {{-- </x-mary-button> --}}
            <x-mary-button
                icon="o-power"
                class="btn-circle"
                tooltip-left="logoff"
                no-wire-navigate
                onclick="document.getElementById('logout-form').submit();"
            />
            {{-- <x-mary-button
                label="Messages"
                icon="o-envelope"
                link="###"
                class="btn-ghost btn-sm"
                responsive
            /> --}}
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button
                        icon="o-bell"
                        label="Notifications"
                        class="btn-ghost btn-sm"
                        responsive
                    />
                </x-slot:trigger>

                @if (auth()->user()->notifications->isEmpty())
                    <x-mary-menu-item
                        title="No notifications available"
                        responsive
                    />
                @else
                    @foreach (auth()->user()->notifications as $notification)
                        <x-mary-menu-item
                            title="{{ $notification->data['message'] }}"
                            link="{{ route('single-request', $notification->data['request_id']) }}"
                            class="{{ $notification->data['status'] == 'approved' ? 'text-emerald-500 hover:text-emerald-500 bg-gray-50 dark:bg-gray-800' : ($notification->data['status'] == 'declined' ? 'text-rose-600 hover:text-rose-600 bg-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:text-gray-500 bg-gray-50 dark:bg-gray-800') }}"
                            responsive
                        />
                    @endforeach
                @endif
            </x-mary-dropdown>
        </x-slot:actions>
    </x-mary-nav>

    {{-- The main content with `full-width` --}}
    <x-mary-main
        with-nav
        full-width
    >

        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar
            drawer="main-drawer"
            collapsible
            class="bg-base-200"
        >
            {{-- User --}}
            @if ($user = auth()->user())
                <x-mary-list-item
                    :item="$user"
                    value="first_name"
                    no-separator
                    no-hover
                    class="pt-2"
                    link="/user/profile"
                >
                    <x-slot:sub-value
                        class="bg-{{ $user->role == 'employee' ? 'emerald-500' : ($user->role == 'manager' ? 'amber-500' : 'rose-600 ') }} px-5 py-0.5 mt-1 text-white font-semibold rounded-full text-lg w-fit capitalize"
                    >{{ $user->role }}</x-slot:sub-value>
                </x-mary-list-item>

                <x-mary-menu-separator />
            @endif

            {{-- Activates the menu item when a route matches the `link` property --}}
            <x-mary-menu activate-by-route>
                <x-mary-menu-item
                    title="dashboard"
                    icon="o-home"
                    link="{{ route('dashboard') }}"
                />

                @can('manage-users')
                    <x-mary-menu-item
                        title="Users"
                        icon="o-user"
                        link="{{ route('users') }}"
                    />
                @endcan

                @can('manage-products')
                    <x-mary-menu-item
                        title="Products"
                        icon="o-archive-box"
                        link="{{ route('products') }}"
                    />
                @endcan

                @can('manage-categories')
                    <x-mary-menu-item
                        title="Categories"
                        icon="o-squares-2x2"
                        link="{{ route('categories') }}"
                    />
                @endcan
                @can('manage-requests')
                    <x-mary-menu-item
                        title="Requests"
                        icon="o-inbox"
                        link="{{ route('requests') }}"
                    />
                @endcan
            </x-mary-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{-- Header --}}
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Content --}}
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{--  TOAST area --}}
    <x-mary-toast />

    <form
        id="logout-form"
        action="{{ route('logout') }}"
        method="POST"
        style="display: none;"
    >
        @csrf
    </form>

    @stack('modals')
</body>

</html>
