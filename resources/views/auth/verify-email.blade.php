<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — AMS Apotek Management System</title>
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
    <div class="auth-card text-center">
        <i class="fa-solid fa-envelope-circle-check mb-3" style="font-size: 4rem; color: #1B5E20;"></i>
        <h4 class="fw-bold mb-3" style="color: #1B5E20;">Verifikasi Email Anda</h4>

        <div class="mb-4 text-sm text-muted">
            Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan yang lain.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mb-4">
                Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
            </div>
        @endif

        <div class="d-flex flex-column gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-3 fw-semibold">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100 py-2 rounded-3 fw-semibold">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</body>
</html>
