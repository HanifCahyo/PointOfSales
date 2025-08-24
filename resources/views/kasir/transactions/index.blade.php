<x-layouts.app title="Transactions">


    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="text-white card-header bg-primary d-flex justify-content-between align-items-center">
                        <span>Daftar Transaksi Saya</span>
                        <a href="{{ route('kasir.transactions.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> New Transaction
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('kasir.transactions.index') }}"
                                        class="row g-3 align-items-end">
                                        <div class="col-md-4">
                                            <label for="filter" class="form-label fw-bold">
                                                <i class="fas fa-filter me-1"></i>Filter Periode:
                                            </label>
                                            <select name="filter" id="filter" class="form-select"
                                                onchange="this.form.submit()">
                                                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua
                                                    Transaksi</option>
                                                <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari
                                                    Ini</option>
                                                <option value="this_week"
                                                    {{ $filter == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                                <option value="this_month"
                                                    {{ $filter == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                                <option value="last_7_days"
                                                    {{ $filter == 'last_7_days' ? 'selected' : '' }}>7 Hari Terakhir
                                                </option>
                                                <option value="last_30_days"
                                                    {{ $filter == 'last_30_days' ? 'selected' : '' }}>30 Hari Terakhir
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($filter !== 'all')
                                                    <a href="{{ route('kasir.transactions.index') }}"
                                                        class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-times me-1"></i>Reset Filter
                                                    </a>
                                                @endif
                                                <div class="text-muted">
                                                    <small><i class="fas fa-info-circle me-1"></i>Filter akan otomatis
                                                        diterapkan saat Anda memilih periode</small>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Section -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card bg-info text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="card-title mb-1">
                                                    <i class="fas fa-chart-line me-1"></i>Total Transaksi
                                                </h6>
                                                <h3 class="mb-0">{{ number_format($totalTransactions) }}</h3>
                                                <small class="opacity-75">
                                                    @switch($filter)
                                                        @case('today')
                                                            Hari ini
                                                        @break

                                                        @case('this_week')
                                                            Minggu ini
                                                        @break

                                                        @case('this_month')
                                                            Bulan ini
                                                        @break

                                                        @case('last_7_days')
                                                            7 hari terakhir
                                                        @break

                                                        @case('last_30_days')
                                                            30 hari terakhir
                                                        @break

                                                        @default
                                                            Semua waktu
                                                    @endswitch
                                                </small>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="card-title mb-1">
                                                    <i class="fas fa-coins me-1"></i>Total Pendapatan
                                                </h6>
                                                <h3 class="mb-0">Rp {{ number_format($totalRevenue) }}</h3>
                                                <small class="opacity-75">
                                                    @if ($totalTransactions > 0)
                                                        Rata-rata: Rp
                                                        {{ number_format(round($totalRevenue / $totalTransactions)) }}
                                                    @else
                                                        Belum ada transaksi
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice</th>
                                        <th>Kategori</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $index => $trx)
                                        <tr>
                                            <td>{{ $transactions->firstItem() + $index }}</td>
                                            <td>{{ $trx->invoice_no }}</td>
                                            <td>
                                                @php
                                                    $categories = $trx->details
                                                        ->map(function ($detail) {
                                                            return $detail->product->category->name ?? '-';
                                                        })
                                                        ->unique()
                                                        ->implode(', ');
                                                @endphp
                                                {{ $categories }}
                                            </td>
                                            <td>Rp {{ number_format($trx->total_amount) }}</td>
                                            <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('kasir.transactions.receipt', $trx->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-receipt"></i> Receipt
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('kasir.transactions.invoice', $trx->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-file-invoice"></i> Invoice
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Tidak ada transaksi</h5>
                                                    <p class="text-muted">Belum ada transaksi untuk periode yang
                                                        dipilih.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
