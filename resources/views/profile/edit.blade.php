<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Profil Saya</h4>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 overflow-hidden">
                <div class="profile-header position-relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff&size=150"
                         alt="{{ Auth::user()->name }}"
                         class="profile-avatar shadow">
                </div>
                <div class="profile-info text-center mt-3">
                    <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
                    <p class="text-muted-custom mb-3">{{ Auth::user()->email }}</p>
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="bi bi-shield-fill-check me-1"></i> Administrator
                    </span>

                    <div class="mt-4 d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profile-form').scrollIntoView({ behavior: 'smooth' })">
                            <i class="bi bi-person-lines-fill me-1"></i> Edit Profil
                        </button>
                        <button class="btn btn-outline-warning btn-sm" onclick="document.getElementById('password-form').scrollIntoView({ behavior: 'smooth' })">
                            <i class="bi bi-key-fill me-1"></i> Ganti Kata Sandi
                        </button>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteAccount">
                            <i class="bi bi-trash3-fill me-1"></i> Hapus Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Update Profile Information -->
            <div class="card mb-4" id="profile-form">
                <div class="card-header fw-bold">
                    <i class="bi bi-person-circle me-2 text-primary"></i>Informasi Pribadi
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Perubahan
                            </button>
                            @if (session('status') === 'profile-updated')
                                <span class="badge bg-success py-2 px-3">
                                    <i class="bi bi-check-circle me-1"></i>Profil berhasil diperbarui!
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4" id="password-form">
                <div class="card-header fw-bold">
                    <i class="bi bi-shield-lock me-2 text-warning"></i>Keamanan & Kata Sandi
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                            <input id="current_password" name="current_password" type="password"
                                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                   autocomplete="current-password" placeholder="Masukkan kata sandi saat ini">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Kata Sandi Baru <span class="text-danger">*</span></label>
                                <input id="password" name="password" type="password"
                                       class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                       autocomplete="new-password" placeholder="Min. 8 karakter">
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                       class="form-control" autocomplete="new-password" placeholder="Ulangi kata sandi baru">
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key me-1"></i>Ganti Kata Sandi
                            </button>
                            @if (session('status') === 'password-updated')
                                <span class="badge bg-success py-2 px-3">
                                    <i class="bi bi-check-circle me-1"></i>Kata sandi berhasil diperbarui!
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Info Widget -->
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="bi bi-info-circle me-2 text-info"></i>Informasi Sistem
                </div>
                <div class="card-body p-0">
                    <div class="px-3">
                        <div class="widget-item">
                            <div class="widget-icon bg-primary text-white">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Tanggal & Waktu Sekarang</h6>
                                <small class="text-muted-custom" id="current-datetime">{{ now()->format('d M Y, H:i:s') }}</small>
                            </div>
                        </div>
                        <div class="widget-item">
                            <div class="widget-icon bg-success text-white">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Status Autentikasi</h6>
                                <small class="text-muted-custom">Terautentikasi sebagai Administrator</small>
                            </div>
                        </div>
                        <div class="widget-item">
                            <div class="widget-icon bg-info text-white">
                                <i class="bi bi-app-indicator"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Versi Sistem</h6>
                                <small class="text-muted-custom">WMS v1.0 — Laravel 12 + Bootstrap 5</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="modalDeleteAccount" tabindex="-1" aria-labelledby="modalDeleteAccountLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="modalDeleteAccountLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Hapus Akun
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p class="text-danger fw-semibold">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
                        <p class="text-muted-custom">Setelah akun dihapus, semua data akun Anda akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengkonfirmasi penghapusan akun.</p>
                        <div class="mb-3">
                            <label for="delete_password" class="form-label fw-semibold">Kata Sandi <span class="text-danger">*</span></label>
                            <input type="password" id="delete_password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   placeholder="Masukkan kata sandi Anda" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3-fill me-1"></i>Ya, Hapus Akun Saya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Live clock on profile page
        function updateClock() {
            const el = document.getElementById('current-datetime');
            if (el) {
                const now = new Date();
                const options = {
                    day: '2-digit', month: 'short', year: 'numeric',
                    hour: '2-digit', minute: '2-digit', second: '2-digit'
                };
                el.textContent = now.toLocaleString('id-ID', options);
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @endpush
</x-app-layout>
