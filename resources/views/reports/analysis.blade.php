<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Analisis Pergerakan Obat</h4>
        <form action="{{ route('analysis.index') }}" method="GET" class="d-flex align-items-center">
            <label for="days" class="me-2 fw-semibold text-nowrap">Periode:</label>
            <select name="days" id="days" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="180" {{ $days == 180 ? 'selected' : '' }}>6 Bulan Terakhir</option>
            </select>
        </form>
    </div>

    <div class="row">
        <!-- Chart Section -->
        <div class="col-12 mb-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fa-solid fa-chart-line me-2"></i>Grafik Pergerakan Obat</span>
                    <select id="productSelect" class="form-select form-select-sm w-auto" onchange="loadChartData()">
                        <option value="" disabled selected>-- Pilih Obat --</option>
                        @foreach($allProducts as $product)
                            <option value="{{ $product->id }}">{{ $product->code }} - {{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body">
                    <div id="chartContainer" style="position: relative; height: 300px; width: 100%; display: none;">
                        <canvas id="movementChart"></canvas>
                    </div>
                    <div id="chartPlaceholder" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-chart-simple display-4 mb-3"></i>
                        <p>Pilih obat dari dropdown di atas untuk melihat grafik pergerakannya.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fast Moving Items -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fa-solid fa-arrow-trend-up me-2"></i>Fast Moving (Sering Keluar)</span>
                    <span class="badge bg-light text-success">Rekomendasi: Perbanyak Stok</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Obat</th>
                                    <th class="text-end">Total Keluar</th>
                                    <th class="text-end">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fastMoving as $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-end fw-bold text-success">{{ $item->stock_outs_sum_quantity ?? 0 }} {{ $item->unit }}</td>
                                        <td class="text-end">{{ $item->current_stock }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data transaksi keluar di periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slow Moving Items -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-danger">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fa-solid fa-arrow-trend-down me-2"></i>Slow Moving (Jarang Keluar)</span>
                    <span class="badge bg-light text-danger">Rekomendasi: Kurangi Pemasukan</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Obat</th>
                                    <th class="text-end">Total Keluar</th>
                                    <th class="text-end">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($slowMoving as $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-end fw-bold text-danger">{{ $item->stock_outs_sum_quantity ?? 0 }} {{ $item->unit }}</td>
                                        <td class="text-end">{{ $item->current_stock }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Semua obat bergerak cepat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let movementChart = null;

        function loadChartData() {
            const productId = document.getElementById('productSelect').value;
            const days = document.getElementById('days').value;
            
            if (!productId) return;

            document.getElementById('chartPlaceholder').style.display = 'none';
            document.getElementById('chartContainer').style.display = 'block';

            fetch(`/api/analysis/product-movement?product_id=${productId}&days=${days}`)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('movementChart').getContext('2d');
                    
                    if (movementChart) {
                        movementChart.destroy();
                    }

                    movementChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Obat Masuk',
                                    data: data.in,
                                    borderColor: '#1B5E20',
                                    backgroundColor: 'rgba(27, 94, 32, 0.1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.3
                                },
                                {
                                    label: 'Obat Keluar',
                                    data: data.out,
                                    borderColor: '#dc3545',
                                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.3
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                })
                .catch(err => console.error('Error loading chart data:', err));
        }
    </script>
    @endpush
</x-app-layout>