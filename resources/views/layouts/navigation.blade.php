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
            $navs = [
                [ 'route' => 'dashboard', 'name' => 'Dashboard' ],
                [ 'route' => 'peminjaman.index', 'name' => 'Peminjaman' ],
                [ 'route' => 'barang.index', 'name' => 'Barang' ],
                [ 'route' => 'lokasi.index', 'name' => 'Lokasi' ],
                [ 'route' => 'kategori.index', 'name' => 'Kategori' ],
                [ 'route' => 'user.index', 'name' => 'User', 'role' => 'admin' ],
            ];
        @endphp

        @foreach ($navs as $nav)
            @php
                $route = $nav['route'];
                $name = $nav['name'];
                $role = $nav['role'] ?? null;
            @endphp

            @if ($role)
                @role($role)
                    <li class="nav-item">
                        <x-nav-link :active="request()->routeIs($route)" :href="route($route)">
                            {{ $name }}
                        </x-nav-link>
                    </li>
                @endrole
            @else
                <li class="nav-item">
                    <x-nav-link :active="request()->routeIs($route)" :href="route($route)">
                        {{ $name }}
                    </x-nav-link>
                </li>
            @endif
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
