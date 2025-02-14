<div>
    @if (Auth::user()->role === 'admin')
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard.index')"
            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </x-nav-link>

        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')"
            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Manajemen User
        </x-nav-link>

        <x-nav-link :href="route('shifts.index')" :active="request()->routeIs('shifts.*')"
            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Manajemen Shift
        </x-nav-link>

        <x-nav-link :href="route('laporan')" :active="request()->routeIs('laporan')"
            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Laporan
        </x-nav-link>
    @else
        <x-nav-link :href="route('absensi')" :active="request()->routeIs('absensi')"
            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Absensi
        </x-nav-link>
    @endif

    <x-nav-link :href="route('izin-cuti.index')" :active="request()->routeIs('izin-cuti.*')"
        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Izin & Cuti
    </x-nav-link>

    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')"
        class="group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        Profile
    </x-nav-link>
</div>
