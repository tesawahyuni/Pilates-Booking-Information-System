<?php

require_once "../config/database.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: ../dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['booking_id'])) {
    die("Booking tidak ditemukan.");
}

$booking_id = intval($_POST['booking_id']);


// ==============================
// Cek Booking
// ==============================

$sql = "SELECT *
        FROM booking
        WHERE id = ?
        AND user_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $booking_id, $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Data booking tidak ditemukan.");
}

$data = mysqli_fetch_assoc($result);


// ==============================
// Cek Upload File
// ==============================

if (!isset($_FILES['bukti'])) {
    die("Silakan upload bukti pembayaran.");
}

$file = $_FILES['bukti'];

if ($file['error'] != 0) {
    die("Upload gagal.");
}

$allowed = ['jpg', 'jpeg', 'png'];

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    die("Format file harus JPG, JPEG, atau PNG.");
}


// ==============================
// Rename File
// ==============================

$namaFile = "PAY-" . time() . "-" . rand(1000,9999) . "." . $ext;

$tujuan = "../uploads/" . $namaFile;


// ==============================
// Upload
// ==============================

if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
    die("Gagal menyimpan file.");
}


// ==============================
// Update Booking
// ==============================

$sql = "UPDATE booking
SET
status_pembayaran='Sudah Bayar',
bukti_transfer=?
WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $namaFile,
    $booking_id
);

if (!mysqli_stmt_execute($stmt)) {
    die("Gagal menyimpan pembayaran.");
}


// ==============================
// Tambah Notifikasi
// ==============================

$sqlNotif = "INSERT INTO notifikasi
(
user_id,
judul,
isi,
jenis
)
VALUES
(
?,
'Pembayaran Berhasil',
'Bukti pembayaran berhasil diupload dan sedang menunggu konfirmasi admin.',
'booking'
)";

$stmtNotif = mysqli_prepare($conn, $sqlNotif);

mysqli_stmt_bind_param(
    $stmtNotif,
    "i",
    $user_id
);

mysqli_stmt_execute($stmtNotif);


// ==============================
// Redirect
// ==============================

echo "<script>

alert('Bukti pembayaran berhasil dikirim.');

window.location='../notification.php';

</script>";

exit();

?>