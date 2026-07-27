<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Sandi — AMS Apotek Management System</title>
    <link rel="icon" type="image/png" href="/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1B5E20 0%, #66BB6A 40%, #E8F5E9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 1.25rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 460px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #1B5E20, #66BB6A);
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            box-shadow: 0 8px 25px rgba(27, 94, 32, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <i class="fa-solid fa-unlock-keyhole" style="font-size: 3rem; color: #1B5E20;"></i>
            <h4 class="fw-bold mt-2" style="color: #1B5E20;">Reset Kata Sandi</h4>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kata Sandi Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary-custom py-2 rounded-3 fw-semibold">Simpan Kata Sandi Baru</button>
            </div>
        </form>
    </div>
</body>
</html>
