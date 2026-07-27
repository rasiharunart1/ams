<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Manajemen Pengguna & Langganan</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddUser">
            <i class="fa-solid fa-user-plus me-2"></i>Tambah Pengguna
        </button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status Langganan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>
                                    {{ $user->email }}
                                    @if($user->hasVerifiedEmail())
                                        <i class="fa-solid fa-circle-check text-success ms-1" title="Terverifikasi"></i>
                                    @else
                                        <i class="fa-solid fa-circle-xmark text-danger ms-1" title="Belum Verifikasi"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'superadmin')
                                        <span class="badge bg-dark">Super Admin</span>
                                    @else
                                        <span class="badge bg-primary">Apoteker</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'superadmin')
                                        <span class="text-muted">-</span>
                                    @elseif(!$user->subscription_ends_at)
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @elseif(\Carbon\Carbon::parse($user->subscription_ends_at)->isPast())
                                        <span class="badge bg-danger">Kedaluwarsa ({{ \Carbon\Carbon::parse($user->subscription_ends_at)->format('d/m/Y') }})</span>
                                    @else
                                        <span class="badge bg-success">Aktif s/d {{ \Carbon\Carbon::parse($user->subscription_ends_at)->format('d/m/Y') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-warning me-1 edit-user-btn" 
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}"
                                            data-subs="{{ $user->subscription_ends_at ? \Carbon\Carbon::parse($user->subscription_ends_at)->format('Y-m-d') : '' }}"
                                            data-msg="{{ $user->subscription_message }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditUser">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada pengguna lain.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Add User -->
    <div class="modal fade" id="modalAddUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('superadmin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="apoteker">Apoteker</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Berlaku Sampai (Langganan)</label>
                            <input type="date" name="subscription_ends_at" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ada batas waktu / untuk superadmin.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pesan Kedaluwarsa Kustom</label>
                            <textarea name="subscription_message" class="form-control" rows="2" placeholder="Kosongkan untuk menggunakan pesan default"></textarea>
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

    <!-- Modal Edit User -->
    <div class="modal fade" id="modalEditUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" id="edit_role" class="form-select" required>
                                <option value="apoteker">Apoteker</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Berlaku Sampai (Langganan)</label>
                            <input type="date" name="subscription_ends_at" id="edit_subs" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pesan Kedaluwarsa Kustom</label>
                            <textarea name="subscription_message" id="edit_msg" class="form-control" rows="2" placeholder="Kosongkan untuk menggunakan pesan default"></textarea>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.edit-user-btn');
            const editForm = document.getElementById('editUserForm');
            
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    editForm.action = `/superadmin/users/${id}`;
                    
                    document.getElementById('edit_name').value = button.getAttribute('data-name');
                    document.getElementById('edit_email').value = button.getAttribute('data-email');
                    document.getElementById('edit_role').value = button.getAttribute('data-role');
                    document.getElementById('edit_subs').value = button.getAttribute('data-subs');
                    document.getElementById('edit_msg').value = button.getAttribute('data-msg');
                });
            });
        });
    </script>
    @endpush
</x-app-layout>