<x-layouts.app title="Dashboard Kasir">
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-tachometer-alt text-primary me-2"></i>
                            Dashboard Kasir
                        </h2>
                        <p class="text-muted mb-0">
                            Selamat datang, {{ Auth::user()->name }}! • {{ date('d F Y') }}
                            <span id="current-time" class="badge bg-primary ms-2"></span>
                            <br><small class="text-info">
                                <i class="fas fa-keyboard me-1"></i>
                                Shortcut: <kbd>Ctrl+N</kbd> Transaksi Baru • <kbd>Ctrl+H</kbd> Riwayat • <kbd>?</kbd>
                                Bantuan
                            </small>
                        </p>
                    </div>
                    <div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('kasir.transactions.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i>Transaksi Baru
                            </a>
                            <a href="{{ route('kasir.transactions.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-1"></i>Lihat Semua
                            </a>
                            @if ($lowStockProducts->count() > 0)
                                <button class="btn btn-outline-warning position-relative" data-bs-toggle="modal"
                                    data-bs-target="#stockModal">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Stok Rendah
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $lowStockProducts->count() }}
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Transaksi Hari Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayTransactions }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pendapatan Hari Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                    {{ number_format($todayRevenue) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Transaksi Bulan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyTransactions }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pendapatan Bulan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                    {{ number_format($monthlyRevenue) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="row mb-4">
            <!-- Quick Actions -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-bolt me-2"></i>Aksi Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <a href="{{ route('kasir.transactions.create') }}"
                                    class="btn btn-primary btn-block btn-lg">
                                    <i class="fas fa-plus fa-2x mb-2"></i><br>
                                    <small>Transaksi Baru</small>
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('kasir.transactions.index') }}"
                                    class="btn btn-info btn-block btn-lg">
                                    <i class="fas fa-history fa-2x mb-2"></i><br>
                                    <small>Riwayat Transaksi</small>
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('kasir.transactions.index', ['filter' => 'today']) }}"
                                    class="btn btn-success btn-block btn-lg">
                                    <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                                    <small>Laporan Hari Ini</small>
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <button class="btn btn-warning btn-block btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#stockModal">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                                    <small>Stok Rendah</small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-area me-2"></i>Performa 7 Hari Terakhir
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Transaksi</th>
                                        <th>Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weeklyStats as $day)
                                        <tr>
                                            <td>
                                                <strong>{{ $day['day'] }}</strong><br>
                                                <small class="text-muted">{{ $day['date'] }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $day['transactions'] }}</span>
                                            </td>
                                            <td>
                                                <small>Rp {{ number_format($day['revenue']) }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-clock me-2"></i>Transaksi Terbaru
                        </h6>
                        <a href="{{ route('kasir.transactions.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($recentTransactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentTransactions as $transaction)
                                            <tr>
                                                <td>
                                                    <strong>{{ $transaction->invoice_no }}</strong>
                                                </td>
                                                <td>
                                                    <small>
                                                        {{ $transaction->details->count() }} item(s)
                                                        @if ($transaction->details->count() > 0)
                                                            <br><span
                                                                class="text-muted">{{ $transaction->details->first()->product->name ?? '' }}{{ $transaction->details->count() > 1 ? ' +' . ($transaction->details->count() - 1) . ' lainnya' : '' }}</span>
                                                        @endif
                                                    </small>
                                                </td>
                                                <td>
                                                    <strong class="text-success">Rp
                                                        {{ number_format($transaction->total_amount) }}</strong>
                                                </td>
                                                <td>
                                                    <small>{{ $transaction->created_at->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('kasir.transactions.receipt', $transaction->id) }}"
                                                            class="btn btn-outline-info btn-sm">
                                                            <i class="fas fa-receipt"></i>
                                                        </a>
                                                        <a href="{{ route('kasir.transactions.invoice', $transaction->id) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-file-invoice"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada transaksi</h5>
                                <p class="text-muted">Mulai transaksi pertama Anda hari ini!</p>
                                <a href="{{ route('kasir.transactions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Buat Transaksi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Alert Modal -->
    <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Produk dengan Stok Rendah
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($lowStockProducts->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Terdapat {{ $lowStockProducts->count() }} produk dengan stok ≤ 10. Harap informasikan ke
                            admin untuk restok.
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lowStockProducts as $product)
                                        <tr>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-secondary">{{ $product->category->name ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $product->stock <= 5 ? 'danger' : 'warning' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                Rp {{ number_format($product->price) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">Semua Produk Aman</h5>
                            <p class="text-muted">Tidak ada produk dengan stok rendah saat ini.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

        .btn-block {
            width: 100%;
        }

        .btn-lg {
            padding: 1rem;
            text-align: center;
        }

        .card {
            border: 0;
            border-radius: 0.35rem;
        }

        .shadow {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .hover-scale:hover {
            transform: scale(1.02);
            transition: transform 0.2s ease-in-out;
        }

        kbd {
            background-color: #212529;
            color: #fff;
            padding: 0.2rem 0.4rem;
            border-radius: 0.2rem;
            font-size: 0.75rem;
            font-family: 'Courier New', monospace;
        }

        .toast-container .toast {
            margin-bottom: 0.5rem;
        }

        .shortcut-indicator {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            z-index: 9999;
        }
    </style>

    <!-- JavaScript for enhanced functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show keyboard shortcuts on load
            showShortcutNotification();

            // Global keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + N for new transaction
                if (e.ctrlKey && e.key === 'n') {
                    e.preventDefault();
                    window.location.href = '{{ route('kasir.transactions.create') }}';
                }
                // Ctrl + H for transaction history
                else if (e.ctrlKey && e.key === 'h') {
                    e.preventDefault();
                    window.location.href = '{{ route('kasir.transactions.index') }}';
                }
                // Ctrl + T for today's report
                else if (e.ctrlKey && e.key === 't') {
                    e.preventDefault();
                    window.location.href =
                    '{{ route('kasir.transactions.index', ['filter' => 'today']) }}';
                }
                // F5 for refresh
                else if (e.key === 'F5') {
                    e.preventDefault();
                    location.reload();
                }
                // Alt + S for stock alert
                else if (e.altKey && e.key === 's') {
                    e.preventDefault();
                    @if ($lowStockProducts->count() > 0)
                        const modal = new bootstrap.Modal(document.getElementById('stockModal'));
                        modal.show();
                    @else
                        showToast('Tidak ada produk dengan stok rendah', 'success');
                    @endif
                }
                // ? for help
                else if (e.key === '?' && !e.ctrlKey && !e.altKey) {
                    e.preventDefault();
                    showShortcutHelp();
                }
            });

            // Add hover effects to cards
            document.querySelectorAll('.card').forEach(card => {
                card.classList.add('hover-scale');
            });

            // Update time every second
            updateDateTime();
            setInterval(updateDateTime, 1000);

            // Auto refresh every 10 minutes
            setTimeout(function() {
                window.location.reload();
            }, 600000); // 10 minutes
        });

        function showShortcutNotification() {
            const toast = `
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div class="toast" id="shortcut-toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <i class="fas fa-keyboard text-primary me-2"></i>
                            <strong class="me-auto">Shortcut Keyboard</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <small>
                                <kbd>Ctrl+N</kbd> Transaksi Baru<br>
                                <kbd>Ctrl+H</kbd> Riwayat<br>
                                <kbd>?</kbd> Bantuan
                            </small>
                        </div>
                    </div>
                </div>
            `;

            if (!document.querySelector('.toast-container')) {
                document.body.insertAdjacentHTML('beforeend', toast);
                const toastElement = new bootstrap.Toast(document.getElementById('shortcut-toast'));
                toastElement.show();
            }
        }

        function showShortcutHelp() {
            const helpModal = `
                <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-question-circle me-2"></i>Bantuan Shortcut Keyboard
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Navigasi Umum</h6>
                                        <div class="mb-2">
                                            <kbd>Ctrl + N</kbd> <span class="ms-2">Transaksi Baru</span>
                                        </div>
                                        <div class="mb-2">
                                            <kbd>Ctrl + H</kbd> <span class="ms-2">Riwayat Transaksi</span>
                                        </div>
                                        <div class="mb-2">
                                            <kbd>Ctrl + T</kbd> <span class="ms-2">Laporan Hari Ini</span>
                                        </div>
                                        <div class="mb-2">
                                            <kbd>F5</kbd> <span class="ms-2">Refresh Halaman</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Fitur Khusus</h6>
                                        <div class="mb-2">
                                            <kbd>Alt + S</kbd> <span class="ms-2">Alert Stok Rendah</span>
                                        </div>
                                        <div class="mb-2">
                                            <kbd>?</kbd> <span class="ms-2">Bantuan ini</span>
                                        </div>
                                        <div class="mb-2">
                                            <kbd>Esc</kbd> <span class="ms-2">Tutup Modal/Batal</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="alert alert-info">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    <strong>Tips:</strong> Gunakan shortcut keyboard untuk bekerja lebih cepat dan efisien!
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            if (!document.getElementById('helpModal')) {
                document.body.insertAdjacentHTML('beforeend', helpModal);
            }
            const modal = new bootstrap.Modal(document.getElementById('helpModal'));
            modal.show();
        }

        function updateDateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            // Update if there's a time display element
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        function showToast(message, type = 'info') {
            const toastHtml = `
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container position-fixed top-0 end-0 p-3';
                document.body.appendChild(container);
            }

            container.insertAdjacentHTML('beforeend', toastHtml);
            const toast = new bootstrap.Toast(container.lastElementChild);
            toast.show();
        }

        // Add visual indicator for keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.altKey) {
                document.body.style.boxShadow = 'inset 0 0 20px rgba(0, 123, 255, 0.3)';
            }
        });

        document.addEventListener('keyup', function(e) {
            if (!e.ctrlKey && !e.altKey) {
                document.body.style.boxShadow = '';
            }
        });
    </script>
</x-layouts.app>
