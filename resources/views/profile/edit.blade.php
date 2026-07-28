<x-app-layout>
    <!-- Subscription Expired Modal -->
    @if(session('subscription_expired'))
        <div class="modal fade" id="subscriptionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-circle-exclamation me-2"></i>Akses Terbatas</h5>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="fa-solid fa-lock text-danger mb-3" style="font-size: 4rem;"></i>
                        <h5 class="fw-bold mb-3">Langganan Kedaluwarsa</h5>
                        <p class="text-muted mb-0">{{ session('subscription_expired') }}</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Keluar dari Sistem</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
                myModal.show();
            });
        </script>
        @endpush
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Profil Saya</h4>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 overflow-hidden">
                <div class="profile-header position-relative">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                             alt="{{ Auth::user()->name }}"
                             class="profile-avatar shadow" id="currentAvatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1B5E20&color=fff&size=150"
                             alt="{{ Auth::user()->name }}"
                             class="profile-avatar shadow" id="currentAvatar">
                    @endif
                </div>
                <div class="profile-info text-center mt-3">
                    <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
                    <p class="text-muted-custom mb-3">{{ Auth::user()->email }}</p>
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="bi bi-shield-fill-check me-1"></i> Administrator
                    </span>

                    <div class="mt-4 d-grid gap-2">
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#avatarModal">
                            <i class="fa-solid fa-camera me-1"></i> Ganti Foto Profil
                        </button>
                        <button class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profile-form').scrollIntoView({ behavior: 'smooth' })">
                            <i class="fa-solid fa-user-pen me-1"></i> Edit Profil
                        </button>
                        <button class="btn btn-outline-warning btn-sm" onclick="document.getElementById('password-form').scrollIntoView({ behavior: 'smooth' })">
                            <i class="fa-solid fa-key me-1"></i> Ganti Kata Sandi
                        </button>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteAccount">
                            <i class="fa-solid fa-trash me-1"></i> Hapus Akun
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

    <!-- Avatar Crop Modal -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #1B5E20, #66BB6A); color: white;">
                    <h5 class="modal-title fw-bold" id="avatarModalLabel">
                        <i class="fa-solid fa-camera me-2"></i>Ganti Foto Profil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Step 1: Upload -->
                    <div id="step-upload" class="text-center py-4">
                        <i class="fa-solid fa-cloud-arrow-up mb-3" style="font-size: 4rem; color: #66BB6A;"></i>
                        <h5 class="fw-bold mb-2">Pilih Foto</h5>
                        <p class="text-muted mb-4">Format: JPG, PNG, GIF. Maks. 5MB</p>
                        <label for="avatarInput" class="btn btn-success px-4">
                            <i class="fa-solid fa-folder-open me-2"></i>Pilih File
                        </label>
                        <input type="file" id="avatarInput" accept="image/*" class="d-none">
                    </div>

                    <!-- Step 2: Crop -->
                    <div id="step-crop" class="d-none">
                        <div class="row">
                            <div class="col-md-8">
                                <div style="max-height: 400px; overflow: hidden;">
                                    <img id="cropImage" src="" style="max-width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                                <p class="fw-semibold mb-2">Preview</p>
                                <div class="rounded-circle overflow-hidden border border-3 border-success mb-3" style="width: 120px; height: 120px;">
                                    <div id="cropPreview" style="width: 120px; height: 120px; overflow: hidden;"></div>
                                </div>
                                <div class="d-grid gap-2 w-100">
                                    <button class="btn btn-outline-secondary btn-sm" id="btnRotateLeft">
                                        <i class="fa-solid fa-rotate-left"></i> Putar Kiri
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" id="btnRotateRight">
                                        <i class="fa-solid fa-rotate-right"></i> Putar Kanan
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" id="btnReset">
                                        <i class="fa-solid fa-xmark"></i> Pilih Ulang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success d-none" id="btnSaveAvatar">
                        <i class="fa-solid fa-floppy-disk me-1"></i>Simpan Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for avatar upload -->
    <form id="avatarForm" method="POST" action="{{ route('profile.avatar') }}" class="d-none">
        @csrf
        <input type="hidden" name="avatar_data" id="avatarData">
    </form>

    @push('scripts')
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
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

        // Avatar Cropper
        let cropper = null;

        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(ev) {
                const cropImage = document.getElementById('cropImage');
                cropImage.src = ev.target.result;

                document.getElementById('step-upload').classList.add('d-none');
                document.getElementById('step-crop').classList.remove('d-none');
                document.getElementById('btnSaveAvatar').classList.remove('d-none');

                if (cropper) cropper.destroy();
                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.8,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    preview: '#cropPreview',
                });
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('btnRotateLeft').addEventListener('click', () => cropper && cropper.rotate(-90));
        document.getElementById('btnRotateRight').addEventListener('click', () => cropper && cropper.rotate(90));

        document.getElementById('btnReset').addEventListener('click', function() {
            if (cropper) { cropper.destroy(); cropper = null; }
            document.getElementById('avatarInput').value = '';
            document.getElementById('step-upload').classList.remove('d-none');
            document.getElementById('step-crop').classList.add('d-none');
            document.getElementById('btnSaveAvatar').classList.add('d-none');
        });

        document.getElementById('btnSaveAvatar').addEventListener('click', function() {
            if (!cropper) return;
            const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
            const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
            document.getElementById('avatarData').value = dataUrl;
            document.getElementById('avatarForm').submit();
        });

        // Reset modal on close
        document.getElementById('avatarModal').addEventListener('hidden.bs.modal', function() {
            if (cropper) { cropper.destroy(); cropper = null; }
            document.getElementById('avatarInput').value = '';
            document.getElementById('step-upload').classList.remove('d-none');
            document.getElementById('step-crop').classList.add('d-none');
            document.getElementById('btnSaveAvatar').classList.add('d-none');
        });

        @if(session('status') === 'avatar-updated')
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 p-3';
                toast.style.zIndex = '9999';
                toast.innerHTML = `<div class="toast show align-items-center text-white bg-success border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body"><i class="fa-solid fa-check-circle me-2"></i>Foto profil berhasil diperbarui!</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 4000);
            });
        @endif
    </script>
    @endpush
</x-app-layout>
