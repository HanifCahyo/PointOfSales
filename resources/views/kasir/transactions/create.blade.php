<x-layouts.app title="Transaksi Baru">
    <div class="py-4 container-fluid">
        <!-- Header Section -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-cash-register text-success me-2"></i>
                            Transaksi Baru
                        </h2>
                        <p class="mb-0 text-muted">Buat transaksi penjualan baru • Kasir: {{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <a href="{{ route('kasir.dashboard') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Dashboard
                        </a>
                        <a href="{{ route('kasir.transactions.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i>Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keyboard Shortcuts Info -->
        <div class="mb-3 row">
            <div class="col-12">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><i class="fas fa-keyboard me-2"></i>Shortcut Keyboard:</strong>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <small>
                                        <kbd>F1</kbd> Cari Produk • <kbd>F2</kbd> Tambah Item
                                    </small>
                                </div>
                                <div class="col-sm-6">
                                    <small>
                                        <kbd>F9</kbd> Simpan • <kbd>Esc</kbd> Batal
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Transaction Form -->
            <div class="col-lg-8">
                <div class="shadow card">
                    <div class="text-white card-header bg-primary">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>Detail Transaksi
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Product Search -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-search me-1"></i>Cari Produk (F1)
                            </label>
                            <div class="input-group">
                                <input type="text" id="product-search" class="form-control"
                                    placeholder="Ketik nama produk atau kode barcode..." autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button" onclick="focusSearch()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div id="search-results" class="mt-2" style="display: none;">
                                <div class="list-group" id="search-list"></div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('kasir.transactions.store') }}" id="transaction-form">
                            @csrf

                            <!-- Selected Products -->
                            <div class="mb-4">
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <label class="mb-0 form-label fw-bold">
                                        <i class="fas fa-list-alt me-1"></i>Produk Terpilih
                                    </label>
                                    <button type="button" onclick="addManualRow()" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus me-1"></i>Tambah Manual (F2)
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="products-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="40%">Produk</th>
                                                <th width="15%">Harga</th>
                                                <th width="15%">Qty</th>
                                                <th width="20%">Subtotal</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product-list">
                                            <tr id="empty-row">
                                                <td colspan="5" class="py-4 text-center text-muted">
                                                    <i class="mb-2 fas fa-shopping-cart fa-2x"></i><br>
                                                    Belum ada produk dipilih.<br>
                                                    <small>Gunakan pencarian produk di atas atau tambah manual</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="button" onclick="clearAll()" class="btn btn-outline-warning">
                                        <i class="fas fa-trash me-1"></i>Hapus Semua
                                    </button>
                                </div>
                                <div>
                                    <button type="button" onclick="window.history.back()"
                                        class="btn btn-secondary me-2">
                                        <i class="fas fa-times me-1"></i>Batal (Esc)
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg" id="save-btn" disabled>
                                        <i class="fas fa-save me-1"></i>Simpan Transaksi (F9)
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Transaction Summary -->
            <div class="col-lg-4">
                <div class="shadow card">
                    <div class="text-white card-header bg-success">
                        <h5 class="mb-0">
                            <i class="fas fa-calculator me-2"></i>Ringkasan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Total Item:</span>
                                <strong id="total-items">0</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Total Qty:</span>
                                <strong id="total-qty">0</strong>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <h5>Total:</h5>
                                <h4 class="text-success" id="grand-total">Rp 0</h4>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="mt-4">
                            <h6 class="fw-bold">Statistik Hari Ini:</h6>
                            <div class="small">
                                <div class="d-flex justify-content-between">
                                    <span>Transaksi:</span>
                                    <span class="badge bg-info">{{ $todayTransactions ?? 0 }}</span>
                                </div>
                                <div class="mt-1 d-flex justify-content-between">
                                    <span>Pendapatan:</span>
                                    <span class="text-success">Rp {{ number_format($todayRevenue ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Access -->
                <div class="mt-4 shadow card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>Akses Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="gap-2 d-grid">
                            <a href="{{ route('kasir.dashboard') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                            <a href="{{ route('kasir.transactions.index') }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-history me-1"></i>Riwayat
                            </a>
                            <a href="{{ route('kasir.transactions.index', ['filter' => 'today']) }}"
                                class="btn btn-outline-success btn-sm">
                                <i class="fas fa-chart-line me-1"></i>Laporan Hari Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        .list-group-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .product-selected {
            background-color: #d4edda !important;
        }

        kbd {
            background-color: #212529;
            color: #fff;
            padding: 0.2rem 0.4rem;
            border-radius: 0.2rem;
            font-size: 0.75rem;
        }

        .table th {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .btn-loading {
            position: relative;
        }

        .btn-loading:disabled {
            pointer-events: none;
        }

        .btn-loading:disabled::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Scripts -->
    <script>
        let productIndex = 0;
        let products = @json($products);
        let selectedProducts = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // F1 - Focus search
                if (e.key === 'F1') {
                    e.preventDefault();
                    focusSearch();
                }
                // F2 - Add manual row
                else if (e.key === 'F2') {
                    e.preventDefault();
                    addManualRow();
                }
                // F9 - Save transaction
                else if (e.key === 'F9') {
                    e.preventDefault();
                    if (!document.getElementById('save-btn').disabled) {
                        document.getElementById('transaction-form').submit();
                    }
                }
                // Escape - Cancel
                else if (e.key === 'Escape') {
                    e.preventDefault();
                    if (confirm('Yakin ingin membatalkan transaksi?')) {
                        window.history.back();
                    }
                }
            });

            // Product search
            const searchInput = document.getElementById('product-search');
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                if (query.length >= 2) {
                    searchProducts(query);
                } else {
                    hideSearchResults();
                }
            });

            // Hide search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#product-search') && !e.target.closest('#search-results')) {
                    hideSearchResults();
                }
            });

            // Focus on search input
            focusSearch();
        });

        function focusSearch() {
            document.getElementById('product-search').focus();
        }

        function searchProducts(query) {
            const results = products.filter(product =>
                product.status === 'active' && (
                    product.name.toLowerCase().includes(query) ||
                    product.code?.toLowerCase().includes(query)
                )
            );

            const searchList = document.getElementById('search-list');
            searchList.innerHTML = '';

            if (results.length > 0) {
                results.slice(0, 10).forEach(product => {
                    const item = document.createElement('div');
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">${product.name}</h6>
                                <small class="text-muted">Stok: ${product.stock} • Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</small>
                            </div>
                            <div>
                                <span class="badge bg-primary">${product.category?.name || '-'}</span>
                            </div>
                        </div>
                    `;
                    item.onclick = () => addProductFromSearch(product);
                    searchList.appendChild(item);
                });
                showSearchResults();
            } else {
                const noResult = document.createElement('div');
                noResult.className = 'list-group-item';
                noResult.innerHTML = '<em class="text-muted">Produk tidak ditemukan</em>';
                searchList.appendChild(noResult);
                showSearchResults();
            }
        }

        function showSearchResults() {
            document.getElementById('search-results').style.display = 'block';
        }

        function hideSearchResults() {
            document.getElementById('search-results').style.display = 'none';
        }

        function addProductFromSearch(product) {
            // Check if product already selected
            const existingIndex = selectedProducts.findIndex(p => p.id === product.id);
            if (existingIndex !== -1) {
                // Increase quantity
                const qtyInput = document.querySelector(`input[name="products[${existingIndex}][quantity]"]`);
                qtyInput.value = parseInt(qtyInput.value) + 1;
                updateSubtotal(existingIndex);
            } else {
                addProductRow(product);
            }

            // Clear search
            document.getElementById('product-search').value = '';
            hideSearchResults();
            focusSearch();
        }

        function addProductRow(product) {
            removeEmptyRow();

            const tbody = document.getElementById('product-list');
            const row = document.createElement('tr');
            row.id = `product-row-${productIndex}`;

            row.innerHTML = `
                <td>
                    <div>
                        <strong>${product.name}</strong><br>
                        <small class="text-muted">Stok: ${product.stock}</small>
                    </div>
                    <input type="hidden" name="products[${productIndex}][id]" value="${product.id}">
                </td>
                <td>
                    <span class="fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                </td>
                <td>
                    <input type="number" name="products[${productIndex}][quantity]"
                           class="form-control" value="1" min="1" max="${product.stock}"
                           onchange="updateSubtotal(${productIndex})" required>
                </td>
                <td>
                    <span class="fw-bold text-success" id="subtotal-${productIndex}">
                        Rp ${new Intl.NumberFormat('id-ID').format(product.price)}
                    </span>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm"
                            onclick="removeProductRow(${productIndex})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(row);
            selectedProducts[productIndex] = product;
            productIndex++;

            updateTotals();
            updateSaveButton();
        }

        function addManualRow() {
            removeEmptyRow();

            const tbody = document.getElementById('product-list');
            const row = document.createElement('tr');
            row.id = `manual-row-${productIndex}`;

            row.innerHTML = `
                <td>
                    <select name="products[${productIndex}][id]" class="form-select" required
                            onchange="updateManualRow(${productIndex})">
                        <option value="">Pilih Produk...</option>
                        ${products.filter(p => p.status === 'active').map(product =>
                            `<option value="${product.id}" data-price="${product.price}" data-stock="${product.stock}">
                                    ${product.name} - Rp ${new Intl.NumberFormat('id-ID').format(product.price)} (Stok: ${product.stock})
                                </option>`
                        ).join('')}
                    </select>
                </td>
                <td>
                    <span class="fw-bold" id="price-${productIndex}">-</span>
                </td>
                <td>
                    <input type="number" name="products[${productIndex}][quantity]"
                           class="form-control" value="1" min="1"
                           onchange="updateSubtotal(${productIndex})" required disabled>
                </td>
                <td>
                    <span class="fw-bold text-success" id="subtotal-${productIndex}">-</span>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm"
                            onclick="removeProductRow(${productIndex})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(row);
            productIndex++;

            updateSaveButton();
        }

        function updateManualRow(index) {
            const select = document.querySelector(`select[name="products[${index}][id]"]`);
            const option = select.selectedOptions[0];

            if (option && option.value) {
                const price = parseInt(option.dataset.price);
                const stock = parseInt(option.dataset.stock);

                document.getElementById(`price-${index}`).textContent =
                `Rp ${new Intl.NumberFormat('id-ID').format(price)}`;

                const qtyInput = document.querySelector(`input[name="products[${index}][quantity]"]`);
                qtyInput.disabled = false;
                qtyInput.max = stock;

                updateSubtotal(index);
            }
        }

        function updateSubtotal(index) {
            const qtyInput = document.querySelector(`input[name="products[${index}][quantity]"]`);
            const select = document.querySelector(`select[name="products[${index}][id]"]`);

            let price = 0;
            if (selectedProducts[index]) {
                price = selectedProducts[index].price;
            } else if (select && select.selectedOptions[0]) {
                price = parseInt(select.selectedOptions[0].dataset.price);
            }

            const quantity = parseInt(qtyInput.value) || 0;
            const subtotal = price * quantity;

            const subtotalEl = document.getElementById(`subtotal-${index}`);
            if (subtotalEl) {
                subtotalEl.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
            }

            updateTotals();
        }

        function removeProductRow(index) {
            const row = document.getElementById(`product-row-${index}`) || document.getElementById(`manual-row-${index}`);
            if (row) {
                row.remove();
                delete selectedProducts[index];
                updateTotals();
                updateSaveButton();

                // Show empty row if no products
                if (document.getElementById('product-list').children.length === 0) {
                    showEmptyRow();
                }
            }
        }

        function removeEmptyRow() {
            const emptyRow = document.getElementById('empty-row');
            if (emptyRow) {
                emptyRow.remove();
            }
        }

        function showEmptyRow() {
            if (!document.getElementById('empty-row')) {
                const tbody = document.getElementById('product-list');
                const emptyRow = document.createElement('tr');
                emptyRow.id = 'empty-row';
                emptyRow.innerHTML = `
                    <td colspan="5" class="py-4 text-center text-muted">
                        <i class="mb-2 fas fa-shopping-cart fa-2x"></i><br>
                        Belum ada produk dipilih.<br>
                        <small>Gunakan pencarian produk di atas atau tambah manual</small>
                    </td>
                `;
                tbody.appendChild(emptyRow);
            }
        }

        function updateTotals() {
            let totalItems = 0;
            let totalQty = 0;
            let grandTotal = 0;

            // Count from table rows
            const rows = document.querySelectorAll('#product-list tr:not(#empty-row)');
            rows.forEach(row => {
                const qtyInput = row.querySelector('input[name$="[quantity]"]');
                if (qtyInput && qtyInput.value) {
                    totalItems++;
                    totalQty += parseInt(qtyInput.value);

                    // Get subtotal from display text
                    const subtotalText = row.querySelector('[id^="subtotal-"]').textContent;
                    const subtotal = parseInt(subtotalText.replace(/[^0-9]/g, '')) || 0;
                    grandTotal += subtotal;
                }
            });

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('total-qty').textContent = totalQty;
            document.getElementById('grand-total').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;
        }

        function updateSaveButton() {
            const hasProducts = document.querySelectorAll('#product-list tr:not(#empty-row)').length > 0;
            document.getElementById('save-btn').disabled = !hasProducts;
        }

        function clearAll() {
            if (confirm('Yakin ingin menghapus semua produk?')) {
                document.getElementById('product-list').innerHTML = '';
                selectedProducts = [];
                productIndex = 0;
                showEmptyRow();
                updateTotals();
                updateSaveButton();
                focusSearch();
            }
        }

        // Form submission
        document.getElementById('transaction-form').addEventListener('submit', function(e) {
            const saveBtn = document.getElementById('save-btn');
            saveBtn.disabled = true;
            saveBtn.classList.add('btn-loading');
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
        });
    </script>
</x-layouts.app>
