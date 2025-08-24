<x-layouts.app title="Product Details">
    <div class="container mt-4">
        <!-- Professional Header -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-eye me-2"></i>Product Details
                                </h4>
                                <small>Viewing product information</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#shortcutsModal">
                                    <i class="fas fa-keyboard me-1"></i>Shortcuts
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="shadow-sm card">
                    <div class="bg-white card-header border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-box me-2"></i>{{ $product->name }}
                            </h5>
                            <div class="gap-2 d-flex">
                                @if ($product->status == 'active')
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times me-1"></i>Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-4 card-body">
                        <!-- Product Information Grid -->
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="p-3 rounded bg-light h-100">
                                    <h6 class="mb-3 text-primary">
                                        <i class="fas fa-info-circle me-2"></i>Basic Information
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold">Product Code</label>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-secondary fs-6 me-2">{{ $product->code }}</span>
                                            <button class="btn btn-outline-secondary btn-sm"
                                                onclick="copyToClipboard('{{ $product->code }}')" title="Copy code">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold">Product Name</label>
                                        <div class="fw-bold fs-5">{{ $product->name }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold">Category</label>
                                        <div>
                                            <span class="badge bg-info fs-6">
                                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label text-muted fw-bold">Product ID</label>
                                        <div class="text-muted">#{{ $product->id }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial & Stock Information -->
                            <div class="col-md-6">
                                <div class="p-3 rounded bg-light h-100">
                                    <h6 class="mb-3 text-primary">
                                        <i class="fas fa-chart-line me-2"></i>Financial & Stock
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold">Price</label>
                                        <div class="fs-4 fw-bold text-success">
                                            <i
                                                class="fas fa-rupiah-sign me-1"></i>{{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold">Current Stock</label>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="badge bg-{{ $product->stock <= 10 ? 'danger' : ($product->stock <= 50 ? 'warning' : 'success') }} fs-6 me-2">
                                                {{ $product->stock }} units
                                            </span>
                                            @if ($product->stock <= 10)
                                                <small class="text-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Low Stock
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold">Stock Value</label>
                                        <div class="fw-bold text-info">
                                            Rp {{ number_format($product->price * $product->stock, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label text-muted fw-bold">Status</label>
                                        <div>
                                            @if ($product->status == 'active')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Available for Sale
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Not Available
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 row">
                            <div class="col-12">
                                <div class="flex-wrap gap-2 d-flex justify-content-center">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"
                                        id="btn-back">
                                        <i class="fas fa-arrow-left me-1"></i>Back to List
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning"
                                        id="btn-edit">
                                        <i class="fas fa-edit me-1"></i>Edit Product
                                    </a>
                                    <button type="button" class="btn btn-success" onclick="printProduct()">
                                        <i class="fas fa-print me-1"></i>Print Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keyboard Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="text-white modal-header bg-primary">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <tr>
                            <td><kbd>E</kbd></td>
                            <td>Edit Product</td>
                        </tr>
                        <tr>
                            <td><kbd>B</kbd> or <kbd>Esc</kbd></td>
                            <td>Back to List</td>
                        </tr>
                        <tr>
                            <td><kbd>P</kbd></td>
                            <td>Print Details</td>
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
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        kbd {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            padding: 2px 6px;
            font-size: 0.875rem;
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        @media print {

            .btn,
            .modal,
            .card-header .btn {
                display: none !important;
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupKeyboardShortcuts();
        });

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                    return;
                }

                switch (e.key.toLowerCase()) {
                    case 'e':
                        e.preventDefault();
                        document.getElementById('btn-edit').click();
                        break;
                    case 'b':
                    case 'escape':
                        e.preventDefault();
                        document.getElementById('btn-back').click();
                        break;
                    case 'p':
                        e.preventDefault();
                        printProduct();
                        break;
                    case 'f1':
                        e.preventDefault();
                        new bootstrap.Modal(document.getElementById('shortcutsModal')).show();
                        break;
                }
            });
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show toast notification
                showToast('Product code copied to clipboard!', 'success');
            });
        }

        function printProduct() {
            window.print();
        }



        function showToast(message, type = 'info') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 3000);
        }
    </script>
</x-layouts.app>
