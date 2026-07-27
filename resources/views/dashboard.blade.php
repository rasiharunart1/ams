<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <h4 class="mb-0 fw-bold me-3">Dasbor</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dasbor</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalResetData">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Reset Semua Data
        </button>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('products.index') }}" class="text-decoration-none">
                <div class="card stat-card stat-card-link">
                    <div class="stat-icon primary"><i class="fa-solid fa-pills"></i></div>
                    <div class="stat-details">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Total Obat</p>
                    </div>
                    <i class="fa-solid fa-circle-arrow-right ms-auto text-primary opacity-50"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('stock-in.index') }}" class="text-decoration-none">
                <div class="card stat-card stat-card-link">
                    <div class="stat-icon success"><i class="fa-solid fa-arrow-right-to-bracket"></i></div>
                    <div class="stat-details">
                        <h3>{{ $stockInMonth }}</h3>
                        <p>Obat Masuk (Bulan Ini)</p>
                    </div>
                    <i class="fa-solid fa-circle-arrow-right ms-auto text-success opacity-50"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('stock-out.index') }}" class="text-decoration-none">
                <div class="card stat-card stat-card-link">
                    <div class="stat-icon warning"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                    <div class="stat-details">
                        <h3>{{ $stockOutMonth }}</h3>
                        <p>Obat Keluar (Bulan Ini)</p>
                    </div>
                    <i class="fa-solid fa-circle-arrow-right ms-auto text-warning opacity-50"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="stat-icon danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="stat-details">
                    <h3>{{ $lowStockCount }}</h3>
                    <p>Stok Menipis / Habis</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Ringkasan Aliran Stok (6 Bulan Terakhir)</span>
                    <i class="fa-solid fa-chart-simple text-muted"></i>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">Obat Berdasarkan Kategori</div>
                <div class="card-body">
                    @if(count($categoryCounts) > 0)
                        <div style="position: relative; height: 320px; width: 100%;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-tags display-6 d-block mb-2 text-muted"></i>
                            Belum ada data kategori.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Transaksi Terakhir</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>No Trx</th>
                                    <th>Tanggal</th>
                                    <th>Obat</th>
                                    <th class="text-end">Jml</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $trx)
                                    <tr>
                                        <td>
                                            @if($trx->type === 'Masuk')
                                                <span class="badge badge-safe">Masuk <i class="fa-solid fa-arrow-down"></i></span>
                                            @else
                                                <span class="badge badge-danger">Keluar <i class="fa-solid fa-arrow-up"></i></span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ $trx->transaction_number }}</td>
                                        <td>{{ Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                                        <td>{{ $trx->product->name }}</td>
                                        <td class="text-end fw-semibold {{ $trx->type === 'Masuk' ? 'text-success' : 'text-danger' }}">
                                            {{ $trx->type === 'Masuk' ? '+' : '-' }}{{ $trx->quantity }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted-custom">
                                            Belum ada aktivitas transaksi terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-danger text-white">Stok Menipis / Peringatan</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($lowStockList as $prod)
                            <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                                <div class="d-flex align-items-center">
                                    <div class="widget-icon bg-light text-danger me-3" style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                        <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold d-block" style="font-size:0.9rem;">{{ $prod->name }}</span>
                                        <small class="text-muted-custom">{{ $prod->code }} | Rak: {{ $prod->rack_location ?? '-' }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger rounded-pill">{{ $prod->current_stock }} {{ $prod->unit }}</span>
                                    <small class="d-block text-muted" style="font-size: 0.75rem;">Min: {{ $prod->minimum_stock }}</small>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted-custom">
                                <i class="fa-solid fa-circle-check text-success d-block display-6 mb-2"></i>
                                Semua stok obat aman.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reset Data -->
    <div class="modal fade" id="modalResetData" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <form action="{{ route('apoteker.reset-data') }}" method="POST" id="resetDataForm">
                    @csrf
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Peringatan Berbahaya</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger fw-bold">Tindakan ini akan menghapus SEMUA data secara permanen:</p>
                        <ul>
                            <li>Semua Kategori</li>
                            <li>Semua Obat</li>
                            <li>Semua Transaksi Masuk & Keluar</li>
                            <li>Semua Log Aktivitas</li>
                        </ul>
                        <p>Data pengguna <strong>tidak</strong> akan dihapus.</p>
                        
                        <hr>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Masukkan Password Anda untuk Konfirmasi</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" id="btnConfirmReset" disabled>
                            Ya, Hapus Semua Data (<span id="countdownText">5</span>)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Theme observer to repaint charts on theme switch
            const getChartColors = () => {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                return {
                    text: isDark ? '#adb5bd' : '#333333',
                    border: isDark ? '#343a40' : '#e9ecef',
                };
            };

            const colors = getChartColors();

            // 1. Stock Trends Line Chart
            const stockCtx = document.getElementById('stockChart').getContext('2d');
            const stockChart = new Chart(stockCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: [
                        {
                            label: 'Obat Masuk',
                            data: {!! json_encode($stockInData) !!},
                            borderColor: '#1B5E20',
                            backgroundColor: 'rgba(27, 94, 32, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Obat Keluar',
                            data: {!! json_encode($stockOutData) !!},
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: colors.text
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: colors.border
                            },
                            ticks: {
                                color: colors.text
                            }
                        },
                        y: {
                            grid: {
                                color: colors.border
                            },
                            ticks: {
                                color: colors.text,
                                stepSize: 10
                            }
                        }
                    }
                }
            });

            // 2. Category Distribution Chart (Only if categories exist)
            @if(count($categoryCounts) > 0)
            const catCtx = document.getElementById('categoryChart').getContext('2d');
            const categoryChart = new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categoryLabels) !!},
                    datasets: [{
                        data: {!! json_encode($categoryCounts) !!},
                        backgroundColor: [
                            '#1B5E20', '#66BB6A', '#A5D6A7', '#E8F5E9', '#0dcaf0', 
                            '#6610f2', '#fd7e14', '#20c997', '#6c757d', '#d63384'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: colors.text,
                                boxWidth: 12
                            }
                        }
                    }
                }
            });
            @endif

            // Observe dark mode switches to toggle chart colors
            const observer = new MutationObserver(() => {
                const updatedColors = getChartColors();
                
                stockChart.options.scales.x.grid.color = updatedColors.border;
                stockChart.options.scales.x.ticks.color = updatedColors.text;
                stockChart.options.scales.y.grid.color = updatedColors.border;
                stockChart.options.scales.y.ticks.color = updatedColors.text;
                stockChart.options.plugins.legend.labels.color = updatedColors.text;
                stockChart.update();

                @if(count($categoryCounts) > 0)
                categoryChart.options.plugins.legend.labels.color = updatedColors.text;
                categoryChart.update();
                @endif
            });

            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

            // Reset Data Modal Logic
            const modalReset = document.getElementById('modalResetData');
            const btnConfirm = document.getElementById('btnConfirmReset');
            const countdownText = document.getElementById('countdownText');
            let countdownInterval;

            modalReset.addEventListener('show.bs.modal', function () {
                let timeLeft = 5;
                btnConfirm.disabled = true;
                btnConfirm.innerHTML = `Ya, Hapus Semua Data (<span id="countdownText">${timeLeft}</span>)`;
                
                countdownInterval = setInterval(() => {
                    timeLeft--;
                    document.getElementById('countdownText').innerText = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        btnConfirm.disabled = false;
                        btnConfirm.innerHTML = `Ya, Hapus Semua Data`;
                    }
                }, 1000);
            });

            modalReset.addEventListener('hidden.bs.modal', function () {
                clearInterval(countdownInterval);
                document.getElementById('resetDataForm').reset();
            });
        });
    </script>
    @endpush
</x-app-layout>
