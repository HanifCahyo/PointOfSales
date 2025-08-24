<x-layouts.app title="Products">
    <div class="mt-4 container-fluid">
        <!-- Professional Header -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-box me-2"></i>Product Management
                                </h4>
                                <small>Kelola seluruh produk toko</small>
                            </div>
                            <div>
                                <!-- Keyboard Shortcuts Help -->
                                <button type="button" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#shortcutsModal">
                                    <i class="fas fa-keyboard me-1"></i>Shortcuts <span
                                        class="badge bg-light text-primary">F1</span>
                                </button>

                                <a href="{{ route('admin.products.create') }}" class="btn btn-success"
                                    id="btn-add-product">
                                    <i class="fas fa-plus me-1"></i>Tambah Produk <span
                                        class="badge bg-success">F2</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Search & Filters -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="shadow-sm card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-search me-2"></i>Search & Filter
                            <span class="badge bg-info ms-2">F3</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="searchForm">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Search Products</label>
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Nama atau kode produk..." autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Category</label>
                                    <select id="categoryFilter" class="form-select">
                                        <option value="">All Categories</option>
                                        <!-- Categories will be populated by JS -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select id="statusFilter" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Stock Level</label>
                                    <select id="stockFilter" class="form-select">
                                        <option value="">All Stock</option>
                                        <option value="low">Low Stock (≤10)</option>
                                        <option value="medium">Medium (11-50)</option>
                                        <option value="high">High (>50)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Actions</label>
                                    <div class="gap-2 d-flex">
                                        <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                            <i class="fas fa-filter me-1"></i>Apply
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="clearFilters()">
                                            <i class="fas fa-times me-1"></i>Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="row">
            <div class="col-12">
                <div class="shadow-sm card">
                    <div class="bg-white card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Products List</h6>
                            <div class="gap-3 d-flex align-items-center">
                                <span class="text-muted small">Total: <span
                                        id="totalProducts">{{ count($products) }}</span> products</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-0 card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover" id="productsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                            <label for="selectAll" class="form-check-label"></label>
                                        </th>

                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr data-id="{{ $product->id }}" class="product-row">
                                            <td>
                                                <input type="checkbox" class="form-check-input product-checkbox"
                                                    value="{{ $product->id }}">
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $product->code }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold">{{ $product->name }}</div>
                                                        <small class="text-muted">ID: #{{ $product->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $product->category->name }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">Rp
                                                    {{ number_format($product->price) }}</div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $product->stock <= 10 ? 'danger' : ($product->stock <= 50 ? 'warning' : 'success') }}">
                                                    {{ $product->stock }} unit
                                                </span>
                                            </td>
                                            <td>
                                                @if ($product->status == 'active')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.products.show', $product) }}"
                                                        class="btn btn-outline-info" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                        class="btn btn-outline-warning" title="Edit Product">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $product) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger"
                                                            onclick="return confirm('Yakin hapus produk ini?')"
                                                            title="Delete Product">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
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

        <!-- Bulk Actions Bar (Hidden by default) -->
        <div id="bulkActionsBar"
            class="bottom-0 px-4 py-3 text-white shadow position-fixed start-50 translate-middle-x bg-dark rounded-top"
            style="display: none; z-index: 1050;">
            <div class="gap-3 d-flex align-items-center">
                <span id="selectedCount">0 selected</span>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-success" onclick="bulkActivate()">
                        <i class="fas fa-check me-1"></i>Activate
                    </button>
                    <button class="btn btn-warning" onclick="bulkDeactivate()">
                        <i class="fas fa-times me-1"></i>Deactivate
                    </button>
                    <button class="btn btn-danger" onclick="bulkDelete()">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
                <button class="btn btn-outline-light btn-sm" onclick="clearSelection()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="text-white modal-header bg-primary">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts - Products
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
                                    <td>Focus Search</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+A</kbd></td>
                                    <td>Select All Products</td>
                                </tr>
                                <tr>
                                    <td><kbd>Delete</kbd></td>
                                    <td>Delete Selected</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-list me-1"></i>Navigation</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><kbd>↑/↓</kbd></td>
                                    <td>Navigate Rows</td>
                                </tr>
                                <tr>
                                    <td><kbd>Enter</kbd></td>
                                    <td>Edit Selected</td>
                                </tr>
                                <tr>
                                    <td><kbd>Space</kbd></td>
                                    <td>Toggle Selection</td>
                                </tr>
                                <tr>
                                    <td><kbd>Esc</kbd></td>
                                    <td>Clear Selection</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .product-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .product-row:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .product-row.selected {
            background-color: rgba(0, 123, 255, 0.2);
        }

        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.75rem;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        let selectedProducts = new Set();
        let currentRow = 0;
        let products = @json($products);

        document.addEventListener('DOMContentLoaded', function() {
            setupKeyboardShortcuts();
            setupTableInteractions();
            populateFilters();
        });

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
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
                        document.getElementById('searchInput').focus();
                        break;
                    case 'a':
                    case 'A':
                        if (e.ctrlKey) {
                            e.preventDefault();
                            selectAllProducts();
                        }
                        break;
                    case 'Delete':
                        if (selectedProducts.size > 0) {
                            bulkDelete();
                        }
                        break;
                    case 'Escape':
                        clearSelection();
                        $('.modal').modal('hide');
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        navigateTable(-1);
                        break;
                    case 'ArrowDown':
                        e.preventDefault();
                        navigateTable(1);
                        break;
                    case 'Enter':
                        if (currentRow >= 0) {
                            const productId = getProductIdFromRow(currentRow);
                            if (productId) {
                                window.location.href = `{{ route('admin.products.edit', $product) }}`;
                            }
                        }
                        break;
                    case ' ':
                        e.preventDefault();
                        if (currentRow >= 0) {
                            toggleRowSelection(currentRow);
                        }
                        break;
                }
            });
        }

        function setupTableInteractions() {
            // Checkbox interactions
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                    if (this.checked) {
                        selectedProducts.add(parseInt(cb.value));
                    } else {
                        selectedProducts.delete(parseInt(cb.value));
                    }
                });
                updateBulkActionsBar();
            });

            // Individual checkbox changes
            document.querySelectorAll('.product-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        selectedProducts.add(parseInt(this.value));
                    } else {
                        selectedProducts.delete(parseInt(this.value));
                    }

                    // Update select all checkbox
                    const totalCheckboxes = document.querySelectorAll('.product-checkbox').length;
                    const checkedCheckboxes = document.querySelectorAll('.product-checkbox:checked').length;
                    const selectAllCheckbox = document.getElementById('selectAll');

                    selectAllCheckbox.checked = checkedCheckboxes === totalCheckboxes;
                    selectAllCheckbox.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes <
                        totalCheckboxes;

                    updateBulkActionsBar();
                });
            });

            // Row click to select
            document.querySelectorAll('.product-row').forEach((row, index) => {
                row.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox' && !e.target.closest('.btn')) {
                        currentRow = index;
                        highlightCurrentRow();
                    }
                });
            });
        }

        function populateFilters() {
            // Populate category filter dengan data dari relasi
            const categories = [...new Set(products.map(p => p.category.name))];
            const categorySelect = document.getElementById('categoryFilter');

            // Clear existing options first (keep "All Categories")
            categorySelect.innerHTML = '<option value="">All Categories</option>';

            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category;
                categorySelect.appendChild(option);
            });
        }

        function applyFilters() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value;
            const status = document.getElementById('statusFilter').value;
            const stockLevel = document.getElementById('stockFilter').value;

            document.querySelectorAll('.product-row').forEach(row => {
                const productName = row.cells[2].textContent.toLowerCase();
                const productCode = row.cells[1].textContent.toLowerCase();
                // Perbaikan: Ambil teks dari badge kategori, bukan seluruh cell
                const productCategory = row.cells[3].querySelector('.badge').textContent.trim();
                const productStatus = row.cells[6].textContent.toLowerCase().includes('active') ? 'active' :
                    'inactive';
                const stock = parseInt(row.cells[5].textContent.match(/\d+/)[0]);

                let show = true;

                // Search filter
                if (search && !productName.includes(search) && !productCode.includes(search)) {
                    show = false;
                }

                // Category filter - perbaikan perbandingan
                if (category && productCategory !== category) {
                    show = false;
                }

                // Status filter
                if (status && productStatus !== status) {
                    show = false;
                }

                // Stock level filter
                if (stockLevel) {
                    if (stockLevel === 'low' && stock > 10) show = false;
                    if (stockLevel === 'medium' && (stock <= 10 || stock > 50)) show = false;
                    if (stockLevel === 'high' && stock <= 50) show = false;
                }

                row.style.display = show ? '' : 'none';
            });

            updateProductCount();
        }

        function clearFilters() {
            document.getElementById('searchForm').reset();
            document.querySelectorAll('.product-row').forEach(row => {
                row.style.display = '';
            });
            updateProductCount();
        }

        function updateProductCount() {
            const visibleRows = document.querySelectorAll('.product-row:not([style*="display: none"])').length;
            document.getElementById('totalProducts').textContent = visibleRows;
        }

        function selectAllProducts() {
            document.getElementById('selectAll').checked = true;
            document.getElementById('selectAll').dispatchEvent(new Event('change'));
        }

        function updateBulkActionsBar() {
            const bar = document.getElementById('bulkActionsBar');
            const count = selectedProducts.size;

            if (count > 0) {
                bar.style.display = 'block';
                document.getElementById('selectedCount').textContent = `${count} selected`;
            } else {
                bar.style.display = 'none';
            }
        }

        function clearSelection() {
            selectedProducts.clear();
            document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            updateBulkActionsBar();
        }

        function navigateTable(direction) {
            const rows = document.querySelectorAll('.product-row:not([style*="display: none"])');
            currentRow = Math.max(0, Math.min(rows.length - 1, currentRow + direction));
            highlightCurrentRow();
        }

        function highlightCurrentRow() {
            document.querySelectorAll('.product-row').forEach((row, index) => {
                row.classList.toggle('table-active', index === currentRow);
            });
        }

        function toggleRowSelection(rowIndex) {
            const checkbox = document.querySelectorAll('.product-checkbox')[rowIndex];
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        }

        function getProductIdFromRow(rowIndex) {
            const row = document.querySelectorAll('.product-row')[rowIndex];
            return row ? row.dataset.id : null;
        }

        function bulkActivate() {
            if (selectedProducts.size > 0 && confirm(`Activate ${selectedProducts.size} products?`)) {
                console.log('Bulk activate:', Array.from(selectedProducts));
                // TODO: Implement bulk activate
            }
        }

        function bulkDeactivate() {
            if (selectedProducts.size > 0 && confirm(`Deactivate ${selectedProducts.size} products?`)) {
                console.log('Bulk deactivate:', Array.from(selectedProducts));
                // TODO: Implement bulk deactivate
            }
        }

        function bulkDelete() {
            if (selectedProducts.size > 0 && confirm(
                    `Delete ${selectedProducts.size} products? This action cannot be undone.`)) {
                console.log('Bulk delete:', Array.from(selectedProducts));
                // TODO: Implement bulk delete
            }
        }

        function changeView(type) {
            document.getElementById('tableView').classList.toggle('active', type === 'table');
            document.getElementById('gridView').classList.toggle('active', type === 'grid');
            // TODO: Implementation for grid view
        }

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('categoryFilter').addEventListener('change', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('stockFilter').addEventListener('change', applyFilters);
    </script>
</x-layouts.app>
