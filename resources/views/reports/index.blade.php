<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Pusat Laporan</h4>
    </div>

    <!-- Filter Form Card -->
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3">Pembuat Laporan</h6>
            <form action="{{ route('reports.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="type" class="form-label fw-semibold">Jenis Laporan <span class="text-danger">*</span></label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="" disabled {{ !request('type') ? 'selected' : '' }}>Pilih Jenis Laporan</option>
                        <option value="stock_in" {{ request('type') === 'stock_in' ? 'selected' : '' }}>Laporan Barang Masuk</option>
                        <option value="stock_out" {{ request('type') === 'stock_out' ? 'selected' : '' }}>Laporan Barang Keluar</option>
                        <option value="inventory" {{ request('type') === 'inventory' ? 'selected' : '' }}>Stok Barang Saat Ini (Inventaris)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <label for="category_id" class="form-label fw-semibold">Kategori</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Pratinjau Laporan</span>
            @if($type && $data->count() > 0)
                <div>
                    <a href="{{ route('reports.export', array_merge(request()->all(), ['format' => 'excel'])) }}" class="btn btn-sm btn-outline-success me-1">
                        <i class="bi bi-file-earmark-excel me-1"></i>Excel
                    </a>
                    <a href="{{ route('reports.export', array_merge(request()->all(), ['format' => 'print'])) }}" target="_blank" class="btn btn-sm btn-outline-danger me-1">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF / Cetak
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body p-0">
            @if(!$type)
                <div class="text-center py-5 text-muted-custom">
                    <i class="bi bi-inbox text-muted-custom" style="font-size: 3rem;"></i>
                    <p class="mt-2">Silakan pilih jenis laporan dan klik tombol cari untuk melihat pratinjau di sini.</p>
                </div>
            @elseif($data->count() == 0)
                <div class="text-center py-5 text-muted-custom">
                    <i class="bi bi-clipboard-x text-muted-custom" style="font-size: 3rem;"></i>
                    <p class="mt-2">Tidak ditemukan data laporan untuk filter yang dipilih.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        @if($type === 'stock_in')
                            <thead>
                                <tr>
                                    <th>No Trx</th>
                                    <th>Tanggal</th>
                                    <th>Kode Produk</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Jml</th>
                                    <th>Satuan</th>
                                    <th>Pemasok</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td class="fw-bold">{{ $row->transaction_number }}</td>
                                        <td>{{ $row->date->format('d/m/Y') }}</td>
                                        <td>{{ $row->product->code }}</td>
                                        <td class="fw-semibold">{{ $row->product->name }}</td>
                                        <td>{{ $row->product->category->name }}</td>
                                        <td class="text-success fw-bold">+{{ $row->quantity }}</td>
                                        <td>{{ $row->product->unit }}</td>
                                        <td>{{ $row->supplier ?? '-' }}</td>
                                        <td>{{ $row->description ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @elseif($type === 'stock_out')
                            <thead>
                                <tr>
                                    <th>No Trx</th>
                                    <th>Tanggal</th>
                                    <th>Kode Produk</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Jml</th>
                                    <th>Satuan</th>
                                    <th>Penerima</th>
                                    <th>Keperluan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td class="fw-bold">{{ $row->transaction_number }}</td>
                                        <td>{{ $row->date->format('d/m/Y') }}</td>
                                        <td>{{ $row->product->code }}</td>
                                        <td class="fw-semibold">{{ $row->product->name }}</td>
                                        <td>{{ $row->product->category->name }}</td>
                                        <td class="text-danger fw-bold">-{{ $row->quantity }}</td>
                                        <td>{{ $row->product->unit }}</td>
                                        <td>{{ $row->receiver ?? '-' }}</td>
                                        <td>{{ $row->purpose ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @elseif($type === 'inventory')
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
                                @foreach($data as $row)
                                    <tr>
                                        <td class="fw-bold">{{ $row->code }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->category->name }}</td>
                                        <td class="fw-semibold">{{ $row->current_stock }} {{ $row->unit }}</td>
                                        <td>{{ $row->minimum_stock }} {{ $row->unit }}</td>
                                        <td>{{ $row->rack_location ?? '-' }}</td>
                                        <td>
                                            @if($row->current_stock <= 0)
                                                <span class="badge badge-danger">Out of Stock 🔴</span>
                                            @elseif($row->current_stock <= $row->minimum_stock)
                                                <span class="badge badge-warning">Warning 🟡</span>
                                            @else
                                                <span class="badge badge-safe">Safe 🟢</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
