@php
    \Carbon\Carbon::setLocale('id');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Efek collapse pada teks menu, logo text, dan logout */
        #sidebar.collapsed .menu-text {
            width: 0;
            opacity: 0;
            overflow: hidden;
            margin-left: 0;
        }

        #sidebar .menu-text {
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        /* Header logo & logout align tengah saat collapsed */
        #sidebar.collapsed #sidebar-header,
        #sidebar.collapsed #logout-btn {
            justify-content: center !important;
        }

        /* Sidebar width transition */
        #sidebar {
            transition: width 0.3s ease;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-gray-100 dark:bg-gray-800 min-h-screen flex flex-col justify-between py-4 px-4 border-r-2
                  transition-all duration-300 ease-in-out w-80 flex-shrink-0">

            <!-- Header Sidebar dengan Logo dan Toggle Button -->
            <div class="border-b border-black dark:border-white pb-4">
                <!-- Logo + Text -->
                <div id="sidebar-header" class="flex items-center justify-start mb-3 transition-all duration-300">
                    <img src="{{ asset('assets/icons/logo.svg') }}" alt="Logo"
                        class="w-8 h-8 flex-shrink-0 dark:filter dark:brightness-0 dark:invert">
                    <span class="menu-text ml-3 text-md font-bold text-gray-800 dark:text-gray-200">
                        Inventory
                    </span>
                </div>

                <!-- Toggle Button -->
                <div class="flex justify-end">
                    <button id="sidebar-toggle"
                        class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <svg id="collapse-icon" class="w-5 h-5 transform rotate-180 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            @php
                $menuItems = [
                    'dashboard' => [
                        'label' => 'Dashboard',
                        'icon' => asset('assets/icons/dashboard.svg'),
                    ],
                    'ruangan.index' => [
                        'label' => 'Ruangan',
                        'icon' => asset('assets/icons/ruangan.svg'),
                    ],
                    'aset.index' => [
                        'label' => 'Aset',
                        'icon' => asset('assets/icons/aset.svg'),
                    ],
                    'riwayat' => [
                        'label' => 'Riwayat',
                        'icon' => asset('assets/icons/history.svg'),
                    ],
                    'pengaturan' => [
                        'label' => 'Pengaturan',
                        'icon' => asset('assets/icons/settings.svg'),
                    ],
                ];
            @endphp

            <!-- Navigation -->
            <nav class="flex-1 flex flex-col justify-center space-y-6 mt-6">
                @foreach ($menuItems as $route => $item)
                    <a href="{{ route($route) }}"
                        class="flex items-center px-4 py-2 rounded transition-all duration-200
                        {{ request()->routeIs($route)
                            ? 'bg-blue-600 text-white shadow-lg border-l-4 border-blue-400'
                            : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 hover:translate-x-1' }}">
                        <img src="{{ $item['icon'] }}" alt="{{ $item['label'] }}"
                            class="w-5 h-5 flex-shrink-0 transition-all duration-200
                                {{ request()->routeIs($route)
                                    ? 'filter brightness-0 invert'
                                    : 'opacity-70 dark:filter dark:brightness-0 dark:invert dark:opacity-100' }}">
                        <span class="menu-text ml-3">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Logout -->
            <div class="border-t border-gray-700 dark:border-white pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button id="logout-btn" type="submit"
                        class="w-full flex items-center justify-start px-2 py-2 text-gray-50 bg-red-600 hover:bg-red-700 dark:text-gray-200 dark:hover:bg-red-800 rounded transition-all duration-200">
                        <img src="{{ asset('assets/icons/logout.svg') }}" alt="Logout"
                            class="w-5 h-5 flex-shrink-0 filter brightness-0 invert">
                        <span class="menu-text ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Header -->
            <header
                class="flex justify-between items-center px-6 py-6 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                <div class="text-md font-semibold text-gray-800 dark:text-gray-100">
                    Selamat Datang, "{{ Auth::user()->name }}"
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const toggleButton = document.getElementById("sidebar-toggle");
        const collapseIcon = document.getElementById("collapse-icon");

        let isCollapsed = false;
        const breakpoint = 1900;

        // Fungsi toggle manual
        function toggleSidebar() {
            sidebar.classList.toggle("collapsed");
            sidebar.classList.toggle("w-80");
            sidebar.classList.toggle("w-20");

            isCollapsed = !isCollapsed;


            collapseIcon.style.transform = isCollapsed ? "rotate(0deg)" : "rotate(180deg)";


            localStorage.setItem("sidebar-collapsed", isCollapsed);
        }

        // Fungsi untuk handle layar resize
        function handleResize() {
            const screenWidth = window.innerWidth;

            if (screenWidth <= breakpoint && !isCollapsed) {
                toggleSidebar();
            } else if (screenWidth > breakpoint && isCollapsed) {
                toggleSidebar();
            }
        }

        // Saat halaman pertama kali load → baca dari localStorage
        document.addEventListener("DOMContentLoaded", () => {
            const savedState = localStorage.getItem("sidebar-collapsed");

            if (savedState === "true" && !isCollapsed) {
                toggleSidebar();
            } else if (savedState === "false" && isCollapsed) {
                toggleSidebar();
            }
        });

        // Event listener untuk tombol manual
        toggleButton.addEventListener("click", toggleSidebar);

        // Event listener resize layar
        window.addEventListener("resize", handleResize);
    </script>

    @yield('scripts')
</body>

</html>
