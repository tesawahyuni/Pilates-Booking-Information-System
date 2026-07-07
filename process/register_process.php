<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "../config/database.php";



// ==============================
// Ambil Data Form
// ==============================

$nama       = trim($_POST['nama']);
$email      = trim($_POST['email']);
$hp         = trim($_POST['hp']);
$password   = $_POST['password'];
$konfirmasi = $_POST['konfirmasi'];

// ==============================
// Validasi Form Kosong
// ==============================

if (
    empty($nama) ||
    empty($email) ||
    empty($hp) ||
    empty($password) ||
    empty($konfirmasi)
) {

    die("Semua data wajib diisi.");

}

// ==============================
// Validasi Email
// ==============================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    die("Format email tidak valid.");

}

// ==============================
// Validasi Password
// ==============================

if ($password != $konfirmasi) {

    die("Konfirmasi password tidak sesuai.");

}

// ==============================
// Cek Email
// ==============================

$cek = mysqli_query(
    $conn,
    "SELECT id FROM users WHERE email='$email'"
);

if (mysqli_num_rows($cek) > 0) {

    die("Email sudah terdaftar.");

}

// ==============================
// Enkripsi Password
// ==============================

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

// ==============================
// Simpan Database
// ==============================

$query = mysqli_query(

    $conn,

    "INSERT INTO users
    (
        nama_lengkap,
        email,
        no_hp,
        password,
        role
    )

    VALUES

    (
        '$nama',
        '$email',
        '$hp',
        '$passwordHash',
        'pelanggan'
    )"

);

// ==============================
// Berhasil
// ==============================

if($query){

    header("Location: ../login.php");

}else{

    die(mysqli_error($conn));

} 

?>