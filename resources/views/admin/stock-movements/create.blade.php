<x-layouts.app title="Stock Movements - Tambah">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Tambah Pergerakan Stok
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.stock-movements.index') }}">Pergerakan
                                Stok</a></li>
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
                                <i class="fas fa-edit mr-2"></i>
                                Form Pergerakan Stok
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('admin.stock-movements.store') }}"
                            id="stock-movement-form">
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
                                                {{ $product->name }} (Stok: {{ number_format($product->stock) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Pilih produk yang akan dikelola stoknya
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
                                            <strong>Stok Tersedia:</strong> <span id="selected-product-stock"
                                                class="badge badge-info">0</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Movement Type -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="movement_type">
                                                <i class="fas fa-exchange-alt mr-1"></i>
                                                Tipe Pergerakan <span class="text-danger">*</span>
                                            </label>
                                            <select name="movement_type" id="movement_type"
                                                class="form-control @error('movement_type') is-invalid @enderror"
                                                required>
                                                <option value="">-- Pilih Tipe --</option>
                                                <option value="IN"
                                                    {{ old('movement_type') == 'IN' ? 'selected' : '' }}>
                                                    <i class="fas fa-arrow-up"></i> Stok Masuk
                                                </option>
                                                <option value="OUT"
                                                    {{ old('movement_type') == 'OUT' ? 'selected' : '' }}>
                                                    <i class="fas fa-arrow-down"></i> Stok Keluar
                                                </option>
                                            </select>
                                            @error('movement_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">
                                                <i class="fas fa-hashtag mr-1"></i>
                                                Kuantitas <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calculator"></i>
                                                    </span>
                                                </div>
                                                <input type="number" name="quantity" id="quantity"
                                                    value="{{ old('quantity') }}"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    min="1" placeholder="Masukkan jumlah" required>
                                            </div>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="stock-warning" class="text-warning" style="display: none;">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                <small>Peringatan: Kuantitas melebihi stok yang tersedia!</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="form-group">
                                    <label for="note">
                                        <i class="fas fa-sticky-note mr-1"></i>
                                        Catatan <small class="text-muted">(Opsional)</small>
                                    </label>
                                    <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="4"
                                        placeholder="Tambahkan catatan tentang pergerakan stok ini...">{{ old('note') }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        Contoh: "Restock dari supplier ABC", "Rusak/expired", "Return pelanggan"
                                    </small>
                                </div>

                                <!-- Summary Card -->
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-clipboard-list mr-1"></i>
                                            Ringkasan Pergerakan
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
                                            <div class="col-md-3">
                                                <div class="description-block">
                                                    <h5 id="summary-type" class="text-muted">-</h5>
                                                    <span class="description-text">Tipe</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="description-block">
                                                    <h5 id="summary-quantity" class="text-muted">-</h5>
                                                    <span class="description-text">Kuantitas</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="description-block">
                                                    <h5 id="summary-final-stock" class="text-muted">-</h5>
                                                    <span class="description-text">Stok Akhir</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-warning mr-2">
                                            <i class="fas fa-undo mr-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <i class="fas fa-save mr-1"></i> Simpan Pergerakan
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
            /* Stock Movements Create Form Styles */
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

            .badge-lg {
                font-size: 0.8em;
                padding: 0.5em 0.8em;
                font-weight: 600;
                border-radius: 6px;
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
                // Product selection handler
                $('#product_id').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const productName = selectedOption.text().split(' (Stok:')[0];
                    const stock = selectedOption.data('stock');

                    if ($(this).val()) {
                        $('#product-info').show();
                        $('#selected-product-name').text(productName);
                        $('#selected-product-stock').text(stock.toLocaleString());
                        updateSummary();
                    } else {
                        $('#product-info').hide();
                        resetSummary();
                    }
                });

                // Movement type handler
                $('#movement_type').on('change', function() {
                    updateSummary();
                    checkStockValidation();
                });

                // Quantity handler
                $('#quantity').on('input', function() {
                    updateSummary();
                    checkStockValidation();
                });

                // Stock validation
                function checkStockValidation() {
                    const movementType = $('#movement_type').val();
                    const quantity = parseInt($('#quantity').val()) || 0;
                    const currentStock = parseInt($('#product_id').find('option:selected').data('stock')) || 0;

                    if (movementType === 'OUT' && quantity > currentStock) {
                        $('#stock-warning').show();
                        $('#submit-btn').attr('disabled', true);
                    } else {
                        $('#stock-warning').hide();
                        $('#submit-btn').attr('disabled', false);
                    }
                }

                // Update summary
                function updateSummary() {
                    const productName = $('#product_id').find('option:selected').text().split(' (Stok:')[0];
                    const movementType = $('#movement_type').val();
                    const quantity = parseInt($('#quantity').val()) || 0;
                    const currentStock = parseInt($('#product_id').find('option:selected').data('stock')) || 0;

                    $('#summary-product').text(productName || '-');

                    if (movementType === 'IN') {
                        $('#summary-type').html('<span class="badge badge-success">Masuk</span>');
                    } else if (movementType === 'OUT') {
                        $('#summary-type').html('<span class="badge badge-danger">Keluar</span>');
                    } else {
                        $('#summary-type').text('-');
                    }

                    $('#summary-quantity').text(quantity > 0 ? quantity.toLocaleString() : '-');

                    if (movementType && quantity > 0) {
                        let finalStock = currentStock;
                        if (movementType === 'IN') {
                            finalStock += quantity;
                        } else if (movementType === 'OUT') {
                            finalStock -= quantity;
                        }

                        const badgeClass = finalStock < 0 ? 'badge-danger' : finalStock < 10 ? 'badge-warning' :
                            'badge-success';
                        $('#summary-final-stock').html(
                            `<span class="badge ${badgeClass}">${finalStock.toLocaleString()}</span>`);
                    } else {
                        $('#summary-final-stock').text('-');
                    }
                }

                function resetSummary() {
                    $('#summary-product').text('-');
                    $('#summary-type').text('-');
                    $('#summary-quantity').text('-');
                    $('#summary-final-stock').text('-');
                }

                // Form submission with loading
                $('#stock-movement-form').on('submit', function() {
                    $('#submit-btn').html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...').attr(
                        'disabled', true);
                });

                // Form reset
                $('button[type="reset"]').on('click', function() {
                    setTimeout(function() {
                        $('#product-info').hide();
                        $('#stock-warning').hide();
                        resetSummary();
                        $('#submit-btn').attr('disabled', false);
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
