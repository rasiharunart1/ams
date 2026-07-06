<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Data Produk</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProduct">
            <i class="bi bi-plus-lg me-2"></i>Tambah Produk
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Toolbar -->
            <form action="{{ route('products.index') }}" method="GET" class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-0">
                    <input type="text" name="search" id="search-product" class="form-control" 
                           placeholder="Cari nama atau kode..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <select class="form-select" name="category_id" id="filter-product-cat" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5 text-md-end">
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-x-circle me-1"></i>Reset
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Rak</th>
                            <th>Stok</th>
                            <th>Min Stok</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="fw-bold">{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->unit }}</td>
                                <td>{{ $product->rack_location ?? '-' }}</td>
                                <td class="fw-semibold">{{ $product->current_stock }}</td>
                                <td>{{ $product->minimum_stock }}</td>
                                <td>
                                    @if($product->current_stock <= 0)
                                        <span class="badge badge-danger">Out of Stock 🔴</span>
                                    @elseif($product->current_stock <= $product->minimum_stock)
                                        <span class="badge badge-warning">Warning 🟡</span>
                                    @else
                                        <span class="badge badge-safe">Safe 🟢</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-info me-1 view-product-btn" 
                                            data-id="{{ $product->id }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalDetailProduct">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning me-1 edit-product-btn" 
                                            data-id="{{ $product->id }}"
                                            data-code="{{ $product->code }}"
                                            data-name="{{ $product->name }}"
                                            data-category="{{ $product->category_id }}"
                                            data-unit="{{ $product->unit }}"
                                            data-rack="{{ $product->rack_location }}"
                                            data-min="{{ $product->minimum_stock }}"
                                            data-current="{{ $product->current_stock }}"
                                            data-desc="{{ $product->description }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditProduct">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted-custom">
                                    <i class="bi bi-box-seam display-6 d-block mb-2 text-muted"></i>
                                    Tidak ada data produk ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="modalProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalProductLabel">Tambah Produk Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label fw-semibold">Kode Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="code" name="code" required placeholder="Contoh: PRD-001">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Contoh: Helm Proyek Krisbow">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="unit_select" class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                                <!-- Hidden input yang benar-benar dikirim ke server -->
                                <input type="hidden" id="unit" name="unit" required>
                                <select class="form-select mb-2" id="unit_select" onchange="handleUnitSelect('unit_select','unit','unit_custom')">
                                    <option value="" disabled selected>-- Pilih Satuan --</option>
                                    <option value="Pcs">Pcs (Pieces)</option>
                                    <option value="Box">Box</option>
                                    <option value="Set">Set</option>
                                    <option value="Roll">Roll</option>
                                    <option value="Pasang">Pasang</option>
                                    <option value="Lusin">Lusin</option>
                                    <option value="Kg">Kg (Kilogram)</option>
                                    <option value="Gram">Gram</option>
                                    <option value="Ons">Ons (100g)</option>
                                    <option value="Liter">Liter</option>
                                    <option value="mL">mL (Mililiter)</option>
                                    <option value="Jerigen">Jerigen</option>
                                    <option value="Karung">Karung</option>
                                    <option value="Lembar">Lembar</option>
                                    <option value="Meter">Meter</option>
                                    <option value="cm">cm (Sentimeter)</option>
                                    <option value="Lainnya">✏️ Lainnya (ketik sendiri)...</option>
                                </select>
                                <input type="text" class="form-control d-none" id="unit_custom"
                                       placeholder="Ketik satuan kustom (contoh: Drum, Ikat, Butir...)"
                                       oninput="document.getElementById('unit').value = this.value">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="rack_location" class="form-label fw-semibold">Lokasi Rak</label>
                                <input type="text" class="form-control" id="rack_location" name="rack_location" placeholder="Contoh: A-1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="current_stock" class="form-label fw-semibold">Stok Awal</label>
                                <input type="number" class="form-control" id="current_stock" name="current_stock" min="0" value="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="minimum_stock" class="form-label fw-semibold">Stok Minimum <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="minimum_stock" name="minimum_stock" min="0" value="10" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Spesifikasi produk atau informasi lainnya..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <div class="modal fade" id="modalEditProduct" tabindex="-1" aria-labelledby="modalEditProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editProductForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalEditProductLabel">Ubah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_code" class="form-label fw-semibold">Kode Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_code" name="code" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_name" class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_unit_select" class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                                <!-- Hidden input yang benar-benar dikirim ke server -->
                                <input type="hidden" id="edit_unit" name="unit" required>
                                <select class="form-select mb-2" id="edit_unit_select" onchange="handleUnitSelect('edit_unit_select','edit_unit','edit_unit_custom')">
                                    <option value="" disabled>-- Pilih Satuan --</option>
                                    <option value="Pcs">Pcs (Pieces)</option>
                                    <option value="Box">Box</option>
                                    <option value="Set">Set</option>
                                    <option value="Roll">Roll</option>
                                    <option value="Pasang">Pasang</option>
                                    <option value="Lusin">Lusin</option>
                                    <option value="Kg">Kg (Kilogram)</option>
                                    <option value="Gram">Gram</option>
                                    <option value="Ons">Ons (100g)</option>
                                    <option value="Liter">Liter</option>
                                    <option value="mL">mL (Mililiter)</option>
                                    <option value="Jerigen">Jerigen</option>
                                    <option value="Karung">Karung</option>
                                    <option value="Lembar">Lembar</option>
                                    <option value="Meter">Meter</option>
                                    <option value="cm">cm (Sentimeter)</option>
                                    <option value="Lainnya">✏️ Lainnya (ketik sendiri)...</option>
                                </select>
                                <input type="text" class="form-control d-none" id="edit_unit_custom"
                                       placeholder="Ketik satuan kustom (contoh: Drum, Ikat, Butir...)"
                                       oninput="document.getElementById('edit_unit').value = this.value">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_rack_location" class="form-label fw-semibold">Lokasi Rak</label>
                                <input type="text" class="form-control" id="edit_rack_location" name="rack_location">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_current_stock" class="form-label fw-semibold">Stok Saat Ini <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_current_stock" name="current_stock" min="0" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_minimum_stock" class="form-label fw-semibold">Stok Minimum <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_minimum_stock" name="minimum_stock" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="modalDetailProduct" tabindex="-1" aria-labelledby="modalDetailProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDetailProductLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detail-product-body">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Memuat...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // ============================================================
        // Satuan Dropdown + Custom Handler
        // ============================================================
        const PREDEFINED_UNITS = [
            'Pcs','Box','Set','Roll','Pasang','Lusin',
            'Kg','Gram','Ons','Liter','mL','Jerigen',
            'Karung','Lembar','Meter','cm'
        ];

        /**
         * Handles the unit select change.
         * @param {string} selectId  - ID of the <select> element
         * @param {string} hiddenId  - ID of the hidden <input name="unit">
         * @param {string} customId  - ID of the custom text input
         */
        function handleUnitSelect(selectId, hiddenId, customId) {
            const sel = document.getElementById(selectId);
            const hidden = document.getElementById(hiddenId);
            const custom = document.getElementById(customId);

            if (sel.value === 'Lainnya') {
                custom.classList.remove('d-none');
                custom.focus();
                hidden.value = '';
            } else {
                custom.classList.add('d-none');
                custom.value = '';
                hidden.value = sel.value;
            }
        }

        /**
         * Pre-fill the unit select/custom input with a saved unit value.
         * If the value is in predefined list → select it, otherwise → pick "Lainnya" and fill custom.
         */
        function prefillUnit(selectId, hiddenId, customId, value) {
            const sel = document.getElementById(selectId);
            const hidden = document.getElementById(hiddenId);
            const custom = document.getElementById(customId);

            hidden.value = value;

            if (PREDEFINED_UNITS.includes(value)) {
                sel.value = value;
                custom.classList.add('d-none');
                custom.value = '';
            } else {
                sel.value = 'Lainnya';
                custom.classList.remove('d-none');
                custom.value = value;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Edit Modal Handler
            const editButtons = document.querySelectorAll('.edit-product-btn');
            const editForm = document.getElementById('editProductForm');
            
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    editForm.action = `/products/${id}`;
                    
                    document.getElementById('edit_code').value = button.getAttribute('data-code');
                    document.getElementById('edit_name').value = button.getAttribute('data-name');
                    document.getElementById('edit_category_id').value = button.getAttribute('data-category');
                    document.getElementById('edit_rack_location').value = button.getAttribute('data-rack') === 'null' ? '' : button.getAttribute('data-rack');
                    document.getElementById('edit_minimum_stock').value = button.getAttribute('data-min');
                    document.getElementById('edit_current_stock').value = button.getAttribute('data-current');
                    document.getElementById('edit_description').value = button.getAttribute('data-desc') === 'null' ? '' : button.getAttribute('data-desc');

                    // Pre-fill unit dropdown
                    prefillUnit('edit_unit_select', 'edit_unit', 'edit_unit_custom', button.getAttribute('data-unit'));
                });
            });

            // Detail Modal Handler via JSON
            const viewButtons = document.querySelectorAll('.view-product-btn');
            const detailBody = document.getElementById('detail-product-body');

            viewButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    detailBody.innerHTML = `
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Memuat...</span>
                            </div>
                        </div>
                    `;

                    fetch(`/products/${id}`)
                        .then(res => res.json())
                        .then(product => {
                            let statusBadge = '';
                            if (product.current_stock <= 0) {
                                statusBadge = '<span class="badge badge-danger">Out of Stock 🔴</span>';
                            } else if (product.current_stock <= product.minimum_stock) {
                                statusBadge = '<span class="badge badge-warning">Warning 🟡</span>';
                            } else {
                                statusBadge = '<span class="badge badge-safe">Safe 🟢</span>';
                            }

                            detailBody.innerHTML = `
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle mb-0">
                                        <tbody>
                                            <tr><th style="width: 40%">Kode Produk</th><td><strong>${product.code}</strong></td></tr>
                                            <tr><th>Nama Produk</th><td>${product.name}</td></tr>
                                            <tr><th>Kategori</th><td>${product.category ? product.category.name : '-'}</td></tr>
                                            <tr><th>Satuan</th><td>${product.unit}</td></tr>
                                            <tr><th>Lokasi Rak</th><td>${product.rack_location ?? '-'}</td></tr>
                                            <tr><th>Stok Saat Ini</th><td><strong class="text-primary">${product.current_stock}</strong></td></tr>
                                            <tr><th>Stok Minimum</th><td>${product.minimum_stock}</td></tr>
                                            <tr><th>Status</th><td>${statusBadge}</td></tr>
                                            <tr><th>Deskripsi</th><td>${product.description ?? '-'}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            `;
                        })
                        .catch(err => {
                            detailBody.innerHTML = `<div class="alert alert-danger mb-0">Gagal mengambil data produk: ${err.message}</div>`;
                        });
                });
            });
        });

        // ============================================================
        // Form submit validation — hidden inputs tidak bisa divalidasi
        // oleh browser secara native, jadi kita cek manual
        // ============================================================
        document.querySelector('form[action="{{ route("products.store") }}"]').addEventListener('submit', function(e) {
            const unitVal = document.getElementById('unit').value.trim();
            if (!unitVal) {
                e.preventDefault();
                // Highlight dropdown
                document.getElementById('unit_select').classList.add('is-invalid');
                document.getElementById('unit_select').focus();
                // Remove highlight after selection
                document.getElementById('unit_select').addEventListener('change', function() {
                    this.classList.remove('is-invalid');
                }, { once: true });
            }
        });

        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            const unitVal = document.getElementById('edit_unit').value.trim();
            if (!unitVal) {
                e.preventDefault();
                document.getElementById('edit_unit_select').classList.add('is-invalid');
                document.getElementById('edit_unit_select').focus();
                document.getElementById('edit_unit_select').addEventListener('change', function() {
                    this.classList.remove('is-invalid');
                }, { once: true });
            }
        });
    </script>
    @endpush
</x-app-layout>
