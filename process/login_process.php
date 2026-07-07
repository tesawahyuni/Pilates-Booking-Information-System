<?php

session_start();

require_once "../config/database.php";

// ==============================
// Ambil Data Form
// ==============================

$email = trim($_POST['email']);
$password = $_POST['password'];

// ==============================
// Validasi
// ==============================

if (empty($email) || empty($password)) {

    die("Email dan password wajib diisi.");

}

// ==============================
// Ambil Data User
// ==============================

$sql = "SELECT * FROM users WHERE email = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// ==============================
// Cek User
// ==============================

if(mysqli_num_rows($result) == 1){

    $user = mysqli_fetch_assoc($result);

    if(password_verify($password, $user['password'])){

        $_SESSION['user_id'] = $user['id'];

        $_SESSION['nama'] = $user['nama_lengkap'];

        $_SESSION['role'] = $user['role'];

        header("Location: ../dashboard.php");

        exit();

    }else{

        die("Password salah.");

    }

}else{

    die("Email tidak ditemukan.");

}

?> 