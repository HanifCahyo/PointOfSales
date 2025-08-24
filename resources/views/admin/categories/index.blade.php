<x-layouts.app title="Categories">
    <div class="mt-4 container-fluid">
        <!-- Professional Header -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-tags me-2"></i>Category Management
                                </h4>
                                <small>Kelola seluruh kategori produk</small>
                            </div>
                            <div>
                                <!-- Keyboard Shortcuts Help -->
                                <button type="button" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#shortcutsModal">
                                    <i class="fas fa-keyboard me-1"></i>Shortcuts <span
                                        class="badge bg-light text-primary">F1</span>
                                </button>

                                <a href="{{ route('admin.category.create') }}" class="btn btn-success"
                                    id="btn-add-category">
                                    <i class="fas fa-plus me-1"></i>Tambah Kategori <span
                                        class="badge bg-success">F2</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Categories Table -->
        <div class="row">
            <div class="col-12">
                <div class="shadow-sm card">
                    <div class="bg-white card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Categories List</h6>
                            <div class="gap-3 d-flex align-items-center">
                                <span class="text-muted small">Total: <span
                                        id="totalCategories">{{ count($categories) }}</span> categories</span>

                            </div>
                        </div>
                    </div>
                    <div class="p-0 card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover" id="categoriesTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Dibuat</th>
                                        <th>Diupdate</th>
                                        <th width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr class="category-row" data-category-id="{{ $category->id }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $category->name }}</div>
                                                        <small class="text-muted">ID: {{ $category->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $category->created_at->format('d M Y') }}<br>
                                                    {{ $category->created_at->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $category->updated_at->format('d M Y') }}<br>
                                                    {{ $category->updated_at->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.category.edit', $category) }}"
                                                        class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                        title="Edit Category">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="viewCategoryDetails({{ $category->id }})"
                                                        data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <form action="{{ route('admin.category.destroy', $category) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Yakin hapus kategori {{ $category->name }}? Ini akan mempengaruhi produk terkait.')"
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="tooltip" title="Delete Category">
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
            class="bottom-0 p-3 text-white shadow-lg position-fixed start-50 translate-middle-x bg-dark rounded-top d-none"
            style="z-index: 1050; min-width: 400px;">
            <div class="d-flex justify-content-between align-items-center">
                <span id="selectedCount">0 categories selected</span>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-light" onclick="bulkEdit()">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                    <button class="btn btn-outline-danger" onclick="bulkDelete()">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                    <button class="btn btn-outline-secondary" onclick="clearSelection()">
                        <i class="fas fa-times me-1"></i>Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="text-white modal-header bg-primary">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts - Categories
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
                                    <td>Add New Category</td>
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
                                    <td><kbd>Escape</kbd></td>
                                    <td>Clear Selection</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3 row">
                        <div class="col-12">
                            <h6 class="text-info"><i class="fas fa-lightbulb me-1"></i>Tips</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-check text-success me-1"></i>Use <kbd>Ctrl+Click</kbd> to select
                                    multiple categories</li>
                                <li><i class="fas fa-check text-success me-1"></i>Double-click a row to quickly edit
                                </li>
                                <li><i class="fas fa-check text-success me-1"></i>Use filters to quickly find specific
                                    categories</li>
                                <li><i class="fas fa-check text-success me-1"></i>Bulk actions appear when multiple
                                    items are selected</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Details Modal -->
    <div class="modal fade" id="categoryDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="text-white modal-header bg-info">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>Category Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="categoryDetailsContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let selectedCategories = new Set();
        let currentRow = -1;
        let categories = @json($categories);

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            setupKeyboardShortcuts();
            setupTableInteractions();
            populateFilters();
            setupTooltips();
        });

        function setupTooltips() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Ignore if user is typing in an input
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName ===
                    'SELECT') {
                    return;
                }

                switch (e.key) {
                    case 'F1':
                        e.preventDefault();
                        new bootstrap.Modal(document.getElementById('shortcutsModal')).show();
                        break;
                    case 'F2':
                        e.preventDefault();
                        window.location.href = '{{ route('admin.category.create') }}';
                        break;
                    case 'Delete':
                        e.preventDefault();
                        if (selectedCategories.size > 0) {
                            bulkDelete();
                        }
                        break;
                    case 'Escape':
                        clearSelection();
                        break;
                    case 'a':
                    case 'A':
                        if (e.ctrlKey || e.metaKey) {
                            e.preventDefault();
                            selectAllCategories();
                        }
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
                            const categoryId = getCategoryIdFromRow(currentRow);
                            if (categoryId) {
                                window.location.href = `{{ url('/admin/categories') }}/${categoryId}/edit`;
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


        function navigateTable(direction) {
            const rows = document.querySelectorAll('.category-row:not([style*="display: none"])');
            currentRow = Math.max(0, Math.min(currentRow + direction, rows.length - 1));
            highlightCurrentRow();
        }

        function highlightCurrentRow() {
            document.querySelectorAll('.category-row').forEach((row, index) => {
                row.classList.toggle('table-active', index === currentRow);
            });
        }

        function toggleRowSelection(rowIndex) {
            const checkbox = document.querySelectorAll('.category-checkbox')[rowIndex];
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        }

        function getCategoryIdFromRow(rowIndex) {
            const row = document.querySelectorAll('.category-row')[rowIndex];
            return row ? row.dataset.categoryId : null;
        }

        function selectAllCategories() {
            document.getElementById('selectAll').checked = true;
            document.getElementById('selectAll').dispatchEvent(new Event('change'));
        }

        function clearSelection() {
            selectedCategories.clear();
            document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            document.getElementById('selectAll').indeterminate = false;
            updateBulkActionsBar();
        }

        function updateBulkActionsBar() {
            const bulkBar = document.getElementById('bulkActionsBar');
            const count = selectedCategories.size;

            if (count > 0) {
                bulkBar.classList.remove('d-none');
                document.getElementById('selectedCount').textContent =
                    `${count} categor${count === 1 ? 'y' : 'ies'} selected`;
            } else {
                bulkBar.classList.add('d-none');
            }
        }

        function viewCategoryDetails(categoryId) {
            const category = categories.find(c => c.id === categoryId);
            if (category) {
                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Basic Information</h6>
                            <table class="table table-sm">
                                <tr><td><strong>ID:</strong></td><td>${category.id}</td></tr>
                                <tr><td><strong>Name:</strong></td><td>${category.name}</td></tr>
                                <tr><td><strong>Products:</strong></td><td>${category.products_count || 0} items</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">Timestamps</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Created:</strong></td><td>${new Date(category.created_at).toLocaleString()}</td></tr>
                                <tr><td><strong>Updated:</strong></td><td>${new Date(category.updated_at).toLocaleString()}</td></tr>
                            </table>
                        </div>
                    </div>
                `;
                document.getElementById('categoryDetailsContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('categoryDetailsModal')).show();
            }
        }

        function bulkEdit() {
            if (selectedCategories.size > 0) {
                console.log('Bulk edit:', Array.from(selectedCategories));
                // TODO: Implement bulk edit functionality
                alert('Bulk edit functionality coming soon!');
            }
        }

        function bulkDelete() {
            if (selectedCategories.size > 0 && confirm(
                    `Delete ${selectedCategories.size} categories? This action cannot be undone and may affect related products.`
                )) {
                console.log('Bulk delete:', Array.from(selectedCategories));
                // TODO: Implement bulk delete
                alert('Bulk delete functionality coming soon!');
            }
        }

        function duplicateCategory(rowIndex) {
            const categoryId = getCategoryIdFromRow(rowIndex);
            if (categoryId) {
                console.log('Duplicate category:', categoryId);
                // TODO: Implement duplicate functionality
                alert('Duplicate functionality coming soon!');
            }
        }

        function printTable() {
            window.print();
        }

        function changeView(type) {
            document.getElementById('tableView').classList.toggle('active', type === 'table');
            document.getElementById('gridView').classList.toggle('active', type === 'grid');
            // TODO: Implementation for grid view
        }

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('sortFilter').addEventListener('change', applyFilters);
    </script>
</x-layouts.app>
