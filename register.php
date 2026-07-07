<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Pilates Booking</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <!-- Logo -->
        <div class="logo">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>

        <!-- Judul -->
        <h1 class="auth-title">
            Buat Akun
        </h1>

        <p class="auth-subtitle">
            Daftar untuk mulai booking kelas pilates favoritmu.
        </p>

        <form action="process/register_process.php" method="POST">

            <div class="form-group">

                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan Nama Lengkap"
                    required>

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan Email"
                    required>

            </div>

            <div class="form-group">

                <label>Nomor HP</label>

                <input
                    type="text"
                    name="hp"
                    placeholder="Contoh: 081234567890"
                    required>

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan Password"
                    required>

            </div>

            <div class="form-group">

                <label>Konfirmasi Password</label>

                <input
                    type="password"
                    name="konfirmasi"
                    placeholder="Masukkan Ulang Password"
                    required>

            </div>

            <button
                type="submit"
                class="btn">

                Daftar

            </button>

        </form>

        <div class="auth-footer">

            Sudah punya akun?

            <a href="login.php">

                Login

            </a>

        </div>

    </div>

</div>

</body>

</html>