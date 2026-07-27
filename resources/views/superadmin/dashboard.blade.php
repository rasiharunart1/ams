<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Super Admin Dashboard</h4>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalResetData">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Reset Semua Data
        </button>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="stat-icon primary"><i class="fa-solid fa-users"></i></div>
                <div class="stat-details">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Apoteker</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="stat-icon success"><i class="fa-solid fa-user-check"></i></div>
                <div class="stat-details">
                    <h3>{{ $activeUsers }}</h3>
                    <p>Langganan Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="stat-icon danger"><i class="fa-solid fa-user-xmark"></i></div>
                <div class="stat-details">
                    <h3>{{ $expiredUsers }}</h3>
                    <p>Langganan Kedaluwarsa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Logs -->
    <div class="card mb-4">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Aktivitas Pengguna Terbaru</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                            <tr>
                                <td class="text-muted small">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td class="fw-semibold">{{ $log->user->name }}</td>
                                <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                                <td>{{ $log->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada aktivitas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- System Logs Iframe -->
    <div class="card">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-server me-2 text-primary"></i>System Logs (Realtime)</span>
            <a href="{{ url('log-viewer') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="fa-solid fa-up-right-from-square"></i> Buka Penuh
            </a>
        </div>
        <div class="card-body p-0">
            <iframe src="{{ url('log-viewer') }}" style="width: 100%; height: 600px; border: none; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem;"></iframe>
        </div>
    </div>

    <!-- Modal Reset Data -->
    <div class="modal fade" id="modalResetData" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <form action="{{ route('superadmin.reset-data') }}" method="POST" id="resetDataForm">
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
                        <p>Data pengguna (Apoteker & Superadmin) <strong>tidak</strong> akan dihapus.</p>
                        
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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