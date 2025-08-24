<x-layouts.app title="Edit Product">
    <div class="container mt-4">
        <!-- Professional Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-warning text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-edit me-2"></i>Edit Product
                                </h4>
                                <small>Modify product information</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#shortcutsModal">
                                    <i class="fas fa-keyboard me-1"></i>Shortcuts
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 text-warning">
                            <i class="fas fa-box me-2"></i>Product Information
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.products.update', $product) }}" id="edit-form">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label fw-bold">
                                            <i class="fas fa-barcode text-primary me-1"></i>Product Code
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="code" id="code"
                                            value="{{ old('code', $product->code) }}"
                                            class="form-control @error('code') is-invalid @enderror" required
                                            placeholder="Enter product code">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Unique identifier for the product</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">
                                            <i class="fas fa-tag text-primary me-1"></i>Product Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $product->name) }}"
                                            class="form-control @error('name') is-invalid @enderror" required
                                            placeholder="Enter product name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label fw-bold">
                                            <i class="fas fa-list text-primary me-1"></i>Category
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="category_id" id="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">Select a category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-bold">
                                            <i class="fas fa-rupiah-sign text-success me-1"></i>Price
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="price" id="price"
                                                value="{{ old('price', $product->price) }}"
                                                class="form-control @error('price') is-invalid @enderror" required
                                                min="0" step="100" placeholder="0">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Price in Indonesian Rupiah</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stock" class="form-label fw-bold">
                                            <i class="fas fa-cubes text-info me-1"></i>Stock Quantity
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="stock" id="stock"
                                            value="{{ old('stock', $product->stock) }}"
                                            class="form-control @error('stock') is-invalid @enderror" required
                                            min="0" placeholder="0">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Current: {{ $product->stock }} units</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-primary me-1"></i>Status
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="">Select status</option>
                                            <option value="active"
                                                {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                                Active - Available for sale
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive - Not available
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Value Display -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-calculator me-2"></i>
                                        <strong>Stock Value:</strong>
                                        <span id="stock-value">Rp
                                            {{ number_format($product->price * $product->stock, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <button type="submit" class="btn btn-warning btn-lg" id="btn-save">
                                            <i class="fas fa-save me-1"></i>Update Product
                                        </button>
                                        <a href="{{ route('admin.products.show', $product) }}"
                                            class="btn btn-info btn-lg" id="btn-preview">
                                            <i class="fas fa-eye me-1"></i>Preview
                                        </a>
                                        <a href="{{ route('admin.products.index') }}"
                                            class="btn btn-secondary btn-lg" id="btn-cancel">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keyboard Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts - Edit
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <tr>
                            <td><kbd>Ctrl+S</kbd></td>
                            <td>Save Changes</td>
                        </tr>
                        <tr>
                            <td><kbd>Ctrl+P</kbd></td>
                            <td>Preview Product</td>
                        </tr>
                        <tr>
                            <td><kbd>Esc</kbd></td>
                            <td>Cancel/Back</td>
                        </tr>
                        <tr>
                            <td><kbd>Tab</kbd></td>
                            <td>Next Field</td>
                        </tr>
                        <tr>
                            <td><kbd>Shift+Tab</kbd></td>
                            <td>Previous Field</td>
                        </tr>
                        <tr>
                            <td><kbd>F1</kbd></td>
                            <td>Show Shortcuts</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        kbd {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            padding: 2px 6px;
            font-size: 0.875rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #f5576c;
            box-shadow: 0 0 0 0.2rem rgba(245, 87, 108, 0.25);
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .alert-info {
            background-color: #e3f2fd;
            border-color: #bbdefb;
            color: #0277bd;
        }

        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:valid,
        .form-control.is-valid {
            border-color: #198754;
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupKeyboardShortcuts();
            setupFormValidation();
            setupStockCalculator();
        });

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key.toLowerCase()) {
                        case 's':
                            e.preventDefault();
                            document.getElementById('edit-form').submit();
                            break;
                        case 'p':
                            e.preventDefault();
                            document.getElementById('btn-preview').click();
                            break;
                    }
                } else {
                    switch (e.key) {
                        case 'Escape':
                            if (!document.querySelector('.modal.show')) {
                                e.preventDefault();
                                document.getElementById('btn-cancel').click();
                            }
                            break;
                        case 'F1':
                            e.preventDefault();
                            new bootstrap.Modal(document.getElementById('shortcutsModal')).show();
                            break;
                    }
                }
            });
        }

        function setupFormValidation() {
            const form = document.getElementById('edit-form');
            const inputs = form.querySelectorAll('input[required], select[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showToast('Please fix the errors before submitting', 'danger');
                }
            });
        }

        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let message = '';

            // Check required fields
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                message = 'This field is required';
            }

            // Specific validations
            if (value && field.name === 'price' && parseFloat(value) < 0) {
                isValid = false;
                message = 'Price must be a positive number';
            }

            if (value && field.name === 'stock' && parseInt(value) < 0) {
                isValid = false;
                message = 'Stock cannot be negative';
            }

            // Update field appearance
            field.classList.toggle('is-invalid', !isValid);
            field.classList.toggle('is-valid', isValid && value);

            // Update feedback message
            const feedback = field.parentNode.querySelector('.invalid-feedback');
            if (feedback && !isValid) {
                feedback.textContent = message;
            }

            return isValid;
        }

        function setupStockCalculator() {
            const priceInput = document.getElementById('price');
            const stockInput = document.getElementById('stock');
            const stockValueDisplay = document.getElementById('stock-value');

            function updateStockValue() {
                const price = parseFloat(priceInput.value) || 0;
                const stock = parseInt(stockInput.value) || 0;
                const totalValue = price * stock;

                stockValueDisplay.textContent = 'Rp ' + totalValue.toLocaleString('id-ID');
            }

            priceInput.addEventListener('input', updateStockValue);
            stockInput.addEventListener('input', updateStockValue);
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 3000);
        }
    </script>
</x-layouts.app>
