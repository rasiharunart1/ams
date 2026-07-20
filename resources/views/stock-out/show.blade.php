<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Detail Transaksi Keluar</h4>
        <a href="{{ route('stock-out.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Informasi Transaksi</div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%">No Transaksi</th>
                            <td>{{ $stockOut->transaction_number }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $stockOut->date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Produk</th>
                            <td>{{ $stockOut->product->name }} <small class="text-muted">({{ $stockOut->product->code }})</small></td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td class="fw-bold text-danger">-{{ $stockOut->quantity }} {{ $stockOut->product->unit }}</td>
                        </tr>
                        <tr>
                            <th>Penerima</th>
                            <td>{{ $stockOut->receiver ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Keperluan</th>
                            <td>{{ $stockOut->purpose ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Bukti Kwitansi</div>
                <div class="card-body">
                    @if($stockOut->receipt_path)
                        @php $ext = pathinfo($stockOut->receipt_path, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/' . $stockOut->receipt_path) }}" class="img-fluid rounded mb-3" alt="Bukti Kwitansi">
                        @else
                            <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                <i class="bi bi-file-earmark-pdf fs-1 text-danger me-3"></i>
                                <div>
                                    <div class="fw-semibold">File PDF</div>
                                    <a href="{{ asset('storage/' . $stockOut->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                        <i class="bi bi-eye me-1"></i>Buka PDF
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdateReceipt">
                                <i class="bi bi-pencil me-1"></i>Ganti Kwitansi
                            </button>
                            <form action="{{ route('stock-out.delete-receipt', $stockOut->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus bukti kwitansi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i>Hapus Kwitansi
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-file-earmark-x display-4 d-block mb-2"></i>
                            Belum ada bukti kwitansi
                        </div>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUpdateReceipt">
                            <i class="bi bi-upload me-1"></i>Upload Kwitansi
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Upload/Ganti Kwitansi -->
    <div class="modal fade" id="modalUpdateReceipt" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('stock-out.update-receipt', $stockOut->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Upload Bukti Kwitansi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="receipt_file_update" class="form-label fw-semibold">
                            File Kwitansi <span class="text-danger">*</span>
                            <small class="text-muted">(JPG, PNG, PDF, maks 2MB)</small>
                        </label>
                        <input type="file" class="form-control" id="receipt_file_update" name="receipt_file"
                               accept=".jpg,.jpeg,.png,.pdf" required>
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
