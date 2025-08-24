<x-layouts.app title="Dashboard Admin">
    <div class="py-4 container-fluid">
        <!-- Header Section -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-tachometer-alt text-primary me-2"></i>
                            Dashboard Admin
                        </h2>
                        <p class="mb-0 text-muted">
                            Selamat datang, {{ Auth::user()->name }}! • {{ date('d F Y') }}
                            <span id="current-time" class="badge bg-primary ms-2"></span>
                            <br><small class="text-info">
                                <i class="fas fa-crown me-1"></i>
                                Panel Administrator - Kelola seluruh sistem POS
                            </small>
                        </p>
                    </div>
                    <div>
                        <!-- Keyboard Shortcuts Help -->
                        <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal"
                            data-bs-target="#shortcutsModal">
                            <i class="fas fa-keyboard me-1"></i>Shortcuts <span class="badge bg-info">F1</span>
                        </button>

                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success" id="btn-add-product">
                                <i class="fas fa-plus me-1"></i>Produk Baru <span class="badge bg-success">F2</span>
                            </a>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary" id="btn-add-user">
                                <i class="fas fa-user-plus me-1"></i>User Baru <span class="badge bg-primary">F3</span>
                            </a>
                            <div class="btn-group" role="group">
                                <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-1"></i>Kelola <span class="badge bg-secondary">F4</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"
                                            id="nav-products">
                                            <i class="fas fa-box me-2"></i>Produk <span
                                                class="badge bg-light text-dark ms-2">P</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.category.index') }}"
                                            id="nav-categories">
                                            <i class="fas fa-tags me-2"></i>Kategori <span
                                                class="badge bg-light text-dark ms-2">K</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}" id="nav-users">
                                            <i class="fas fa-users me-2"></i>Users <span
                                                class="badge bg-light text-dark ms-2">U</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.stock-movements.index') }}"
                                            id="nav-stock-movements">
                                            <i class="fas fa-exchange-alt me-2"></i>Stock Movement <span
                                                class="badge bg-light text-dark ms-2">S</span>
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.stock-opnames.index') }}"
                                            id="nav-stock-opnames">
                                            <i class="fas fa-clipboard-list me-2"></i>Stock Opname <span
                                                class="badge bg-light text-dark ms-2">O</span>
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.audit-logs.index') }}"
                                            id="nav-audit-logs">
                                            <i class="fas fa-history me-2"></i>Audit Log <span
                                                class="badge bg-light text-dark ms-2">A</span>
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview Stats Cards -->
        <div class="mb-4 row">
            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-primary h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-primary text-uppercase">
                                    Total Users
                                </div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $totalUsers }}</div>
                                <small class="text-muted">{{ $totalKasir }} Kasir</small>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-success text-uppercase">
                                    Total Produk
                                </div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $totalProducts }}</div>
                                <small class="text-muted">{{ $activeProducts }} Aktif</small>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-info h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-info text-uppercase">
                                    Kategori
                                </div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $totalCategories }}</div>
                                <small class="text-muted">Total kategori produk</small>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-tags fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-warning h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-warning text-uppercase">
                                    Stok Rendah
                                </div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $lowStockProducts->count() }}
                                </div>
                                <small class="text-muted">Produk perlu restok</small>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Stats -->
        <div class="mb-4 row">
            <div class="mb-4 col-xl-4 col-lg-6">
                <div class="text-white shadow card bg-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs text-white font-weight-bold text-uppercase">
                                    Pendapatan Hari Ini
                                </div>
                                <div class="mb-0 h4 font-weight-bold">Rp {{ number_format($todayRevenue) }}</div>
                                <small class="opacity-75">{{ $todayTransactions }} transaksi</small>
                            </div>
                            <div class="col-auto">
                                <i class="text-white opacity-50 fas fa-calendar-day fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-4 col-lg-6">
                <div class="text-white shadow card bg-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs text-white font-weight-bold text-uppercase">
                                    Pendapatan Bulan Ini
                                </div>
                                <div class="mb-0 h4 font-weight-bold">Rp {{ number_format($monthlyRevenue) }}</div>
                                <small class="opacity-75">{{ $monthlyTransactions }} transaksi</small>
                            </div>
                            <div class="col-auto">
                                <i class="text-white opacity-50 fas fa-calendar-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-4 col-lg-6">
                <div class="text-white shadow card bg-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs text-white font-weight-bold text-uppercase">
                                    Pendapatan Tahun Ini
                                </div>
                                <div class="mb-0 h4 font-weight-bold">Rp {{ number_format($yearlyRevenue) }}</div>
                                <small class="opacity-75">{{ $yearlyTransactions }} transaksi</small>
                            </div>
                            <div class="col-auto">
                                <i class="text-white opacity-50 fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Analytics -->
        <div class="mb-4 row">
            <!-- Revenue Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="mb-4 shadow card">
                    <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-area me-2"></i>Tren Pendapatan 12 Bulan Terakhir
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="mb-4 shadow card">
                    <div class="py-3 card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-pie me-2"></i>Status Produk
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="pt-4 pb-2 chart-pie">
                            <canvas id="productStatusChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Aktif
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-danger"></i> Tidak Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Tables Row -->
        <div class="row">
            <!-- Top Products -->
            <div class="col-xl-8 col-lg-7">
                <div class="mb-4 shadow card">
                    <div class="py-3 card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-star me-2"></i>Produk Terlaris Bulan Ini
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Terjual</th>
                                        <th>Stok</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topProducts as $index => $product)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $index < 3 ? ['warning', 'secondary', 'success'][$index] : 'light' }}">
                                                    #{{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $product->product_name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $product->category_name }}</span>
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ $product->total_sold }}</strong>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $product->stock <= 10 ? 'danger' : 'success' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>Rp {{ number_format($product->total_revenue) }}</strong>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-4 text-center text-muted">
                                                <i class="mb-2 fas fa-shopping-cart fa-2x"></i><br>
                                                Belum ada data penjualan bulan ini
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kasir Performance -->
            <div class="col-xl-4 col-lg-5">
                <div class="mb-4 shadow card">
                    <div class="py-3 card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-users me-2"></i>Performa Kasir Bulan Ini
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($kasirPerformance as $kasir)
                            <div class="py-3 d-flex align-items-center border-bottom">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="text-white fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-gray-500 small">{{ $kasir->name }}</div>
                                    <div class="font-weight-bold">
                                        Rp {{ number_format($kasir->monthly_revenue) }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $kasir->monthly_transactions }} transaksi
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-4 text-center">
                                <i class="mb-2 fas fa-user-times fa-2x text-muted"></i>
                                <p class="text-muted">Belum ada data kasir</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Alerts -->
        <div class="row">
            <!-- Recent Transactions -->
            <div class="col-xl-8">
                <div class="mb-4 shadow card">
                    <div class="py-3 card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-clock me-2"></i>Transaksi Terbaru
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Kasir</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $transaction)
                                        <tr>
                                            <td>
                                                <strong>{{ $transaction->invoice_no }}</strong>
                                            </td>
                                            <td>{{ $transaction->user->name ?? 'Unknown' }}</td>
                                            <td>
                                                <small>{{ $transaction->details->count() }} item(s)</small>
                                            </td>
                                            <td>
                                                <strong class="text-success">Rp
                                                    {{ number_format($transaction->total_amount) }}</strong>
                                            </td>
                                            <td>
                                                <small>{{ $transaction->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-center text-muted">
                                                Belum ada transaksi
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="col-xl-4">
                <div class="mb-4 shadow card">
                    <div class="py-3 card-header">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>Alert Stok Rendah
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($lowStockProducts as $product)
                            <div class="py-2 d-flex align-items-center border-bottom">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="text-white fas fa-box"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">{{ $product->name }}</div>
                                    <div class="text-gray-500 small">
                                        {{ $product->category->name ?? '-' }}
                                    </div>
                                    <div class="small">
                                        <span class="badge bg-{{ $product->stock <= 5 ? 'danger' : 'warning' }}">
                                            Stok: {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-4 text-center">
                                <i class="mb-2 fas fa-check-circle fa-2x text-success"></i>
                                <p class="text-success">Semua produk stok aman</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .text-xs {
            font-size: 0.7rem;
        }

        .card {
            border: 0;
            border-radius: 0.35rem;
        }

        .shadow {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }

        .icon-circle {
            height: 2.5rem;
            width: 2.5rem;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-area {
            position: relative;
            height: 300px;
        }

        .chart-pie {
            position: relative;
            height: 200px;
        }

        #revenueChart,
        #productStatusChart {
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update time
            updateDateTime();
            setInterval(updateDateTime, 1000);

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($monthlyRevenueChart->pluck('month')),
                    datasets: [{
                        label: 'Revenue (Rp)',
                        data: @json($monthlyRevenueChart->pluck('revenue')),
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Product Status Chart
            const statusCtx = document.getElementById('productStatusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Aktif', 'Tidak Aktif'],
                    datasets: [{
                        data: [{{ $activeProducts }}, {{ $inactiveProducts }}],
                        backgroundColor: ['#1cc88a', '#e74a3b'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Auto refresh every 10 minutes
            setTimeout(function() {
                location.reload();
            }, 600000);

            // Keyboard Shortcuts
            setupKeyboardShortcuts();
        });

        function updateDateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            document.getElementById('current-time').textContent = timeString;
        }

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Prevent shortcuts when typing in inputs
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName ===
                    'SELECT') {
                    return;
                }

                switch (e.key) {
                    case 'F1':
                        e.preventDefault();
                        $('#shortcutsModal').modal('show');
                        break;
                    case 'F2':
                        e.preventDefault();
                        window.location.href = '{{ route('admin.products.create') }}';
                        break;
                    case 'F3':
                        e.preventDefault();
                        window.location.href = '{{ route('admin.users.create') }}';
                        break;
                    case 'p':
                    case 'P':
                        if (e.ctrlKey || e.altKey) {
                            e.preventDefault();
                            window.location.href = '{{ route('admin.products.index') }}';
                        }
                        break;
                    case 'k':
                    case 'K':
                        if (e.ctrlKey || e.altKey) {
                            e.preventDefault();
                            window.location.href = '{{ route('admin.category.index') }}';
                        }
                        break;
                    case 'u':
                    case 'U':
                        if (e.ctrlKey || e.altKey) {
                            e.preventDefault();
                            window.location.href = '{{ route('admin.users.index') }}';
                        }
                        break;
                    case 's':
                    case 'S':
                        if (e.ctrlKey || e.altKey) {
                            e.preventDefault();
                            window.location.href = '{{ route('admin.stock-movements.index') }}';
                        }
                        break;
                    case 'o':
                    case 'O':
                        if (e.ctrlKey || e.altKey) {
                            e.preventDefault();
                            window.location.href = '{{ route('admin.stock-opnames.index') }}';
                        }
                        break;
                    case 'a':
                    case 'A':
                        if (e.ctrlKey || e.altKey) {
                            e.preventDefault();
                            window.location.href = '{{ route('admin.audit-logs.index') }}';
                        }
                        break;
                    case 'Escape':
                        // Close any open modals
                        $('.modal').modal('hide');
                        break;
                }
            });

            // Show shortcut hints on hover
            document.querySelectorAll('[data-shortcut]').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    showTooltip(this, this.dataset.shortcut);
                });
            });
        }

        function showTooltip(element, shortcut) {
            // Create tooltip for shortcuts
            const tooltip = document.createElement('div');
            tooltip.className = 'position-absolute bg-dark text-white px-2 py-1 rounded small';
            tooltip.style.zIndex = '9999';
            tooltip.textContent = `Shortcut: ${shortcut}`;

            element.appendChild(tooltip);

            setTimeout(() => {
                if (tooltip.parentElement) {
                    tooltip.remove();
                }
            }, 2000);
        }
    </script>

    <!-- Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts - Admin Panel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary"><i class="fas fa-bolt me-1"></i>Quick Actions</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><kbd>F1</kbd></td>
                                    <td>Show Shortcuts</td>
                                </tr>
                                <tr>
                                    <td><kbd>F2</kbd></td>
                                    <td>Add New Product</td>
                                </tr>
                                <tr>
                                    <td><kbd>F3</kbd></td>
                                    <td>Add New User</td>
                                </tr>
                                <tr>
                                    <td><kbd>F4</kbd></td>
                                    <td>Management Menu</td>
                                </tr>
                                <tr>
                                    <td><kbd>Esc</kbd></td>
                                    <td>Close Modal/Cancel</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-list me-1"></i>Navigation (Ctrl/Alt + Key)</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><kbd>Ctrl+P</kbd></td>
                                    <td>Products Management</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+K</kbd></td>
                                    <td>Categories Management</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+U</kbd></td>
                                    <td>Users Management</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+S</kbd></td>
                                    <td>Stock Movements</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+O</kbd></td>
                                    <td>Stock Opname</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+A</kbd></td>
                                    <td>Audit Logs</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3 p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Tip:</strong> Shortcuts tidak akan berfungsi saat Anda sedang mengetik di form
                            input.
                            Press <kbd>Esc</kbd> untuk keluar dari input field dan menggunakan shortcuts.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
