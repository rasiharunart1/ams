<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Transaksi Barang Masuk</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStockIn">
            <i class="fa-solid fa-plus me-2"></i>Tambah Data Masuk
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Toolbar -->
            <form action="{{ route('stock-in.index') }}" method="GET" class="row mb-3">
                <div class="col-md-4 mb-2 mb-md-0">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari No Trx atau nama produk..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-5 text-md-end">
                    @if(request('search') || request('date'))
                        <a href="{{ route('stock-in.index') }}" class="btn btn-outline-secondary me-2">
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
                            <th>No Trx</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Satuan</th>
                            <th>Jml</th>
                            <th>Pemasok</th>
                            <th>Keterangan</th>
                            <th>Kwitansi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockIns as $trx)
                            <tr>
                                <td class="fw-bold">{{ $trx->transaction_number }}</td>
                                <td>{{ $trx->date->format('d/m/Y') }}</td>
                                <td>
                                    <span class="d-block fw-semibold">{{ $trx->product->name }}</span>
                                    <small class="text-muted-custom">{{ $trx->product->code }}</small>
                                </td>
                                <td>{{ $trx->product->unit }}</td>
                                <td class="fw-bold text-success">+{{ $trx->quantity }}</td>
                                <td>{{ $trx->supplier ?? '-' }}</td>
                                <td class="text-muted-custom">{{ $trx->description ?? '-' }}</td>
                                <td>
                                    @if($trx->receipt_path)
                                        <a href="{{ asset('storage/' . $trx->receipt_path) }}" target="_blank" class="btn btn-outline-success" title="Lihat Kwitansi">
                                            <i class="fa-solid fa-receipt"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('stock-in.show', $trx->id) }}"
                                       class="btn btn-outline-info me-1" title="Detail & Kelola Kwitansi">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('stock-in.receipt', $trx->id) }}" target="_blank"
                                       class="btn btn-outline-primary me-1" title="Cetak Struk PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <form action="{{ route('stock-in.destroy', $trx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Stok produk akan dikurangi kembali.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Batalkan Transaksi">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted-custom">
                                    <i class="bi bi-box-arrow-in-down display-6 d-block mb-2 text-muted"></i>
                                    Tidak ada data transaksi masuk ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $stockIns->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Masuk -->
    <div class="modal fade" id="modalStockIn" tabindex="-1" aria-labelledby="modalStockInLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('stock-in.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalStockInLabel">Tambah Data Barang Masuk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="transaction_number" class="form-label fw-semibold">No Transaksi (Opsional)</label>
                            <input type="text" class="form-control" id="transaction_number" name="transaction_number" placeholder="Biarkan kosong untuk otomatis">
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label fw-semibold">Produk <span class="text-danger">*</span></label>
                            <select class="form-select" id="product_id" name="product_id" required>
                                <option value="" disabled selected>Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->code }} - {{ $product->name }} (Stok: {{ $product->current_stock }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required placeholder="Min 1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="supplier" class="form-label fw-semibold">Pemasok / Supplier</label>
                            <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Contoh: PT. Sumber Makmur">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Keterangan</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Alasan masuk atau keterangan lain..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="receipt_file" class="form-label fw-semibold">Bukti Kwitansi <small class="text-muted">(JPG, PNG, PDF, maks 2MB)</small></label>
                            <input type="file" class="form-control" id="receipt_file" name="receipt_file" accept=".jpg,.jpeg,.png,.pdf">
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
</x-app-layout>
