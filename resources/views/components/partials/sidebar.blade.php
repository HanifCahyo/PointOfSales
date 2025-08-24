<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Point Of Sales</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column" style="min-height: 100vh;">
        <!-- Sidebar user (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">

            <div class="info">
                <a href="#" class="d-block">Halo! {{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- ROLE ADMIN --}}
                @if (request()->is('admin*'))
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard Admin</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.category.index') }}"
                            class="nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}"
                            class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Produk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.stock-movements.index') }}"
                            class="nav-link {{ request()->routeIs('admin.stock-movements.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>Pergerakan Stok</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.stock-opnames.index') }}"
                            class="nav-link {{ request()->routeIs('admin.stock-opnames.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Stock Opname</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.audit-logs.index') }}"
                            class="nav-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Audit Logs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                @endif

                {{-- ROLE KASIR --}}
                @if (request()->is('kasir*'))
                    <li class="nav-item">
                        <a href="{{ route('kasir.dashboard') }}"
                            class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Dashboard Kasir</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kasir.transactions.index') }}"
                            class="nav-link {{ request()->routeIs('kasir.transactions.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>
                @endif

                <!-- Logout Menu -->
                <li class="mt-auto nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="p-0 nav-link">
                        @csrf
                        <button type="submit" class="text-left text-white btn btn-link nav-link w-100"
                            style="text-decoration: none; border: none; background: none;"
                            onclick="return confirm('Yakin ingin logout?')">
                            <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                            <p class="text-white">Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
