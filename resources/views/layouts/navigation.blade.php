<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo style="height: 32px; width:auto;" />
        </a>

        <!-- Toggler (hamburger) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                @php
                    // Menu utama
                    $navs = [
                        [ 'route' => 'dashboard', 'name' => 'Dashboard' ],
                        [ 'route' => 'peminjaman.index', 'name' => 'Peminjaman' ],
                    ];

                    // Dropdown Data Barang
                    $dataBarang = [
                        [ 'route' => 'barang.index', 'name' => 'Barang' ],
                        [ 'route' => 'lokasi.index', 'name' => 'Lokasi' ],
                        [ 'route' => 'kategori.index', 'name' => 'Kategori' ],
                        [ 'route' => 'sumberdana.index', 'name' => 'Sumber Dana' ],
                    ];

                    // Tentukan halaman aktif di dalam dropdown
                    $activeDropdownName = 'Data Barang'; // default
                    foreach ($dataBarang as $item) {
                        if (request()->routeIs($item['route'])) {
                            $activeDropdownName = $item['name'];
                            break;
                        }
                    }

                    // Menu khusus role admin
                    $adminNavs = [
                        [ 'route' => 'user.index', 'name' => 'User', 'role' => 'admin' ],
                    ];
                @endphp

                {{-- Menu utama --}}
                @foreach ($navs as $nav)
                    <li class="nav-item">
                        <x-nav-link :active="request()->routeIs($nav['route'])" :href="route($nav['route'])">
                            {{ $nav['name'] }}
                        </x-nav-link>
                    </li>
                @endforeach

                {{-- Dropdown Data Barang --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('barang*') || request()->is('lokasi*') || request()->is('kategori*') || request()->is('sumberdana*') ? 'active' : '' }}"
                       href="#" id="dataBarangDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $activeDropdownName }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dataBarangDropdown">
                        @foreach ($dataBarang as $item)
                            <li>
                                <a class="dropdown-item {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                                   href="{{ route($item['route']) }}">
                                    {{ $item['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Menu khusus admin --}}
                @foreach ($adminNavs as $nav)
                    @role($nav['role'])
                        <li class="nav-item">
                            <x-nav-link :active="request()->routeIs($nav['route'])" :href="route($nav['route'])">
                                {{ $nav['name'] }}
                            </x-nav-link>
                        </li>
                    @endrole
                @endforeach
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                <!-- Dropdown User -->
                <x-dropdown>
                    <x-slot name="trigger">
                        {{ Auth::user()->name }}
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </ul>
        </div>
    </div>
</nav>
