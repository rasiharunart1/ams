<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Pemantauan Stok Barang</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Toolbar -->
            <form action="{{ route('inventory.index') }}" method="GET" class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-0">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama atau kode produk..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <select class="form-select" name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="safe" {{ request('status') === 'safe' ? 'selected' : '' }}>Safe (Aman) 🟢</option>
                        <option value="warning" {{ request('status') === 'warning' ? 'selected' : '' }}>Warning (Menipis) 🟡</option>
                        <option value="danger" {{ request('status') === 'danger' ? 'selected' : '' }}>Out of Stock (Habis) 🔴</option>
                    </select>
                </div>
                <div class="col-md-5 text-md-end">
                    @if(request('search') || request('status'))
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary me-2">
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
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok Saat Ini</th>
                            <th>Min Stok</th>
                            <th>Lokasi Rak</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="fw-bold">{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td class="fw-bold {{ $product->current_stock <= $product->minimum_stock ? 'text-danger' : 'text-success' }}">
                                    {{ $product->current_stock }} {{ $product->unit }}
                                </td>
                                <td>{{ $product->minimum_stock }} {{ $product->unit }}</td>
                                <td>{{ $product->rack_location ?? '-' }}</td>
                                <td>
                                    @if($product->current_stock <= 0)
                                        <span class="badge badge-danger">Out of Stock 🔴</span>
                                    @elseif($product->current_stock <= $product->minimum_stock)
                                        <span class="badge badge-warning">Warning 🟡</span>
                                    @else
                                        <span class="badge badge-safe">Safe 🟢</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted-custom">
                                    <i class="bi bi-clipboard-data display-6 d-block mb-2 text-muted"></i>
                                    Tidak ada data stok ditemukan.
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
</x-app-layout>
