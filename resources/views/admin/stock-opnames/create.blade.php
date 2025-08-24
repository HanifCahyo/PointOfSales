<x-layouts.app title="Stock Opnames - Tambah">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Stock Opname
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.stock-opnames.index') }}">Stock Opname</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5><i class="icon fas fa-ban"></i> Terjadi Kesalahan!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Form Card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-clipboard-check mr-2"></i>
                                Form Stock Opname
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('admin.stock-opnames.store') }}" id="stock-opname-form">
                            @csrf
                            <div class="card-body">
                                <!-- Product Selection -->
                                <div class="form-group">
                                    <label for="product_id">
                                        <i class="fas fa-box mr-1"></i>
                                        Produk <span class="text-danger">*</span>
                                    </label>
                                    <select name="product_id" id="product_id"
                                        class="form-control @error('product_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} (Stok Sistem: {{ number_format($product->stock) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Pilih produk yang akan dihitung stock opname-nya
                                    </small>
                                </div>

                                <!-- Selected Product Info -->
                                <div id="product-info" class="alert alert-info" style="display: none;">
                                    <h6><i class="fas fa-info-circle mr-1"></i> Informasi Produk</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Nama Produk:</strong> <span id="selected-product-name">-</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Stok Sistem:</strong> <span id="selected-product-stock"
                                                class="badge badge-secondary">0</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- System Stock -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="system_stock">
                                                <i class="fas fa-desktop mr-1"></i>
                                                Stok Sistem
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-desktop"></i>
                                                    </span>
                                                </div>
                                                <input type="number" id="system_stock" class="form-control bg-light"
                                                    readonly>
                                            </div>
                                            <small class="form-text text-muted">Stok yang tercatat di sistem</small>
                                        </div>
                                    </div>

                                    <!-- Physical Stock -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="physical_stock">
                                                <i class="fas fa-hands mr-1"></i>
                                                Stok Fisik <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-hands"></i>
                                                    </span>
                                                </div>
                                                <input type="number" name="physical_stock" id="physical_stock"
                                                    value="{{ old('physical_stock') }}"
                                                    class="form-control @error('physical_stock') is-invalid @enderror"
                                                    min="0" placeholder="Hasil perhitungan fisik" required>
                                            </div>
                                            @error('physical_stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Stok yang dihitung secara fisik</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Difference Display -->
                                <div class="form-group">
                                    <label for="difference">
                                        <i class="fas fa-balance-scale mr-1"></i>
                                        Selisih
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-balance-scale"></i>
                                            </span>
                                        </div>
                                        <input type="number" id="difference" class="form-control bg-light" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="difference-status">
                                                <i class="fas fa-equals"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Selisih antara stok fisik dan stok
                                        sistem</small>
                                </div>

                                <!-- Notes -->
                                <div class="form-group">
                                    <label for="note">
                                        <i class="fas fa-sticky-note mr-1"></i>
                                        Catatan <small class="text-muted">(Opsional)</small>
                                    </label>
                                    <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="4"
                                        placeholder="Tambahkan catatan tentang hasil stock opname...">{{ old('note') }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        Contoh: "Ada barang rusak 5 unit", "Ditemukan barang expired", "Kesalahan
                                        pencatatan sebelumnya"
                                    </small>
                                </div>

                                <!-- Summary Card -->
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-clipboard-list mr-1"></i>
                                            Ringkasan Stock Opname
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-md-3">
                                                <div class="description-block">
                                                    <h5 id="summary-product" class="text-muted">-</h5>
                                                    <span class="description-text">Produk</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="description-block">
                                                    <h5 id="summary-system" class="text-muted">-</h5>
                                                    <span class="description-text">Sistem</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="description-block">
                                                    <h5 id="summary-physical" class="text-muted">-</h5>
                                                    <span class="description-text">Fisik</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="description-block">
                                                    <h5 id="summary-difference" class="text-muted">-</h5>
                                                    <span class="description-text">Selisih</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="description-block">
                                                    <h5 id="summary-status" class="text-muted">-</h5>
                                                    <span class="description-text">Status</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.stock-opnames.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-warning mr-2">
                                            <i class="fas fa-undo mr-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <i class="fas fa-save mr-1"></i> Simpan Opname
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            /* Stock Opnames Create Form Styles */
            .content-header h1 {
                font-weight: 600;
                color: #2c3e50;
            }

            .breadcrumb {
                background: transparent;
                margin-bottom: 0;
            }

            .breadcrumb-item+.breadcrumb-item::before {
                content: "›";
                font-weight: bold;
            }

            .card-outline.card-primary {
                border-top: 4px solid #007bff;
                box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
            }

            .card-header {
                background: linear-gradient(135deg, #667eea 0%, #4b69a2 100%);
                color: white;
                border-bottom: none;
            }

            .card-header .card-title {
                font-weight: 600;
                margin: 0;
            }

            .form-control {
                border-radius: 6px;
                border: 1px solid #ced4da;
                transition: all 0.2s ease;
            }

            .form-control:focus {
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                border-color: #007bff;
            }

            .form-group label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 0.5rem;
            }

            .input-group-text {
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                border: 1px solid #ced4da;
                color: #6c757d;
            }

            .btn {
                border-radius: 6px;
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .btn-primary {
                background: linear-gradient(135deg, #007bff, #0056b3);
                border: none;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #0056b3, #004085);
                transform: translateY(-1px);
            }

            .btn-success {
                background: linear-gradient(135deg, #28a745, #1e7e34);
                border: none;
            }

            .btn-secondary {
                background: linear-gradient(135deg, #6c757d, #5a6268);
                border: none;
            }

            .btn-warning {
                background: linear-gradient(135deg, #ffc107, #e0a800);
                border: none;
                color: #000;
            }

            .alert {
                border-radius: 8px;
                border: none;
                border-left: 4px solid;
            }

            .alert-danger {
                background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
                border-left-color: #dc3545;
                color: #721c24;
            }

            .alert-info {
                background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(23, 162, 184, 0.05));
                border-left-color: #17a2b8;
                color: #0c5460;
            }

            .badge {
                font-size: 0.8em;
                padding: 0.5em 0.8em;
                font-weight: 600;
                border-radius: 6px;
            }

            .badge-secondary {
                background: linear-gradient(135deg, #6c757d, #5a6268);
                border: none;
            }

            .badge-success {
                background: linear-gradient(135deg, #28a745, #20c997);
                border: none;
            }

            .badge-danger {
                background: linear-gradient(135deg, #dc3545, #e83e8c);
                border: none;
            }

            .badge-warning {
                background: linear-gradient(135deg, #ffc107, #fd7e14);
                color: #000;
                border: none;
            }

            #product-info {
                background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(23, 162, 184, 0.05));
                border: 1px solid rgba(23, 162, 184, 0.2);
                border-radius: 8px;
            }

            .description-block {
                padding: 15px 10px;
                text-align: center;
            }

            .description-block h5 {
                font-weight: 700;
                margin-bottom: 8px;
                font-size: 1.2rem;
            }

            .description-text {
                font-size: 0.85rem;
                color: #6c757d;
                text-transform: uppercase;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            .text-success {
                color: #28a745 !important;
            }

            .text-danger {
                color: #dc3545 !important;
            }

            .text-warning {
                color: #ffc107 !important;
            }

            .select2-container--bootstrap4 .select2-selection--single {
                height: calc(2.25rem + 2px);
                border-radius: 6px;
            }

            .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
                line-height: calc(2.25rem);
            }

            @media (max-width: 768px) {
                .btn-sm {
                    font-size: 0.75rem;
                    padding: 0.25rem 0.5rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                const productSelect = $('#product_id');
                const systemStockInput = $('#system_stock');
                const physicalStockInput = $('#physical_stock');
                const differenceInput = $('#difference');

                // Product selection handler
                productSelect.on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const productName = selectedOption.text().split(' (Stok Sistem:')[0];
                    const stock = selectedOption.data('stock');

                    if ($(this).val()) {
                        $('#product-info').show();
                        $('#selected-product-name').text(productName);
                        $('#selected-product-stock').text(stock.toLocaleString());
                        systemStockInput.val(stock || '');
                        updateSummary();
                    } else {
                        $('#product-info').hide();
                        systemStockInput.val('');
                        resetSummary();
                    }
                    calculateDifference();
                });

                // Physical stock input handler
                physicalStockInput.on('input', function() {
                    calculateDifference();
                    updateSummary();
                });

                // Calculate difference function
                function calculateDifference() {
                    const systemStock = parseInt(systemStockInput.val()) || 0;
                    const physicalStock = parseInt(physicalStockInput.val()) || 0;
                    const difference = physicalStock - systemStock;

                    differenceInput.val(difference);

                    // Update styling based on difference
                    const statusIcon = $('#difference-status i');
                    if (difference > 0) {
                        differenceInput.removeClass('text-danger').addClass('text-success');
                        $('#difference-status').removeClass('text-danger text-warning').addClass('text-success');
                        statusIcon.removeClass('fa-equals fa-arrow-down').addClass('fa-arrow-up');
                    } else if (difference < 0) {
                        differenceInput.removeClass('text-success').addClass('text-danger');
                        $('#difference-status').removeClass('text-success text-warning').addClass('text-danger');
                        statusIcon.removeClass('fa-equals fa-arrow-up').addClass('fa-arrow-down');
                    } else {
                        differenceInput.removeClass('text-success text-danger');
                        $('#difference-status').removeClass('text-success text-danger').addClass('text-warning');
                        statusIcon.removeClass('fa-arrow-up fa-arrow-down').addClass('fa-equals');
                    }
                }

                // Update summary
                function updateSummary() {
                    const productName = $('#product_id').find('option:selected').text().split(' (Stok Sistem:')[0];
                    const systemStock = parseInt($('#system_stock').val()) || 0;
                    const physicalStock = parseInt($('#physical_stock').val()) || 0;
                    const difference = physicalStock - systemStock;

                    $('#summary-product').text(productName || '-');
                    $('#summary-system').text(systemStock > 0 ? systemStock.toLocaleString() : '-');
                    $('#summary-physical').text(physicalStock > 0 ? physicalStock.toLocaleString() : '-');

                    if (!isNaN(difference) && (systemStock > 0 || physicalStock > 0)) {
                        const prefix = difference > 0 ? '+' : '';
                        const badgeClass = difference > 0 ? 'badge-success' : (difference < 0 ? 'badge-danger' :
                            'badge-warning');
                        $('#summary-difference').html(
                            `<span class="badge ${badgeClass}">${prefix}${difference.toLocaleString()}</span>`);

                        // Update status
                        if (difference > 0) {
                            $('#summary-status').html('<span class="badge badge-success">Stok Lebih</span>');
                        } else if (difference < 0) {
                            $('#summary-status').html('<span class="badge badge-danger">Stok Kurang</span>');
                        } else {
                            $('#summary-status').html('<span class="badge badge-warning">Stok Sesuai</span>');
                        }
                    } else {
                        $('#summary-difference').text('-');
                        $('#summary-status').text('-');
                    }
                }

                function resetSummary() {
                    $('#summary-product').text('-');
                    $('#summary-system').text('-');
                    $('#summary-physical').text('-');
                    $('#summary-difference').text('-');
                    $('#summary-status').text('-');
                }

                // Form submission with loading
                $('#stock-opname-form').on('submit', function() {
                    $('#submit-btn').html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...').attr(
                        'disabled', true);
                });

                // Form reset
                $('button[type="reset"]').on('click', function() {
                    setTimeout(function() {
                        $('#product-info').hide();
                        resetSummary();
                        differenceInput.removeClass('text-success text-danger');
                        $('#difference-status').removeClass('text-success text-danger').addClass(
                            'text-warning');
                        $('#difference-status i').removeClass('fa-arrow-up fa-arrow-down').addClass(
                            'fa-equals');
                    }, 100);
                });

                // Initialize Select2 for better UX
                if (typeof $.fn.select2 !== 'undefined') {
                    $('#product_id').select2({
                        placeholder: "-- Pilih Produk --",
                        allowClear: true,
                        width: '100%',
                        theme: 'bootstrap4'
                    });
                }
            });
        </script>
    @endpush
</x-layouts.app>
