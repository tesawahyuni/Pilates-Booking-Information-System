<?php
session_start();



if(isset($_SESSION['user_id'])){

    header("Location: dashboard.php");

    exit();

}

?>



<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pilates Booking</title>

    <!-- CSS -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
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
            Pilates Booking
        </h1>

        <p class="auth-subtitle">
            Selamat datang kembali 👋 <br>
            Silakan login untuk mulai booking kelas.
        </p>
        <!-- FORM LOGIN -->

        <form action="process/login_process.php" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan Email"
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

            <button
                type="submit"
                class="btn btn-login">

                Masuk

            </button>
        </form>

        <div class="auth-footer">
            Belum punya akun?
            <a href="register.php">
                Daftar
            </a>
        </div>
    </div>
</div>
</body>
</html>  