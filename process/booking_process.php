<?php

require_once "../config/database.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['jadwal_id'])) {
    die("Jadwal tidak ditemukan.");
}

$jadwal_id = intval($_POST['jadwal_id']);


// ==============================
// Cek Jadwal
// ==============================

$sql = "SELECT id, kuota
        FROM jadwal
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $jadwal_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Jadwal tidak ditemukan.");
}

$jadwal = mysqli_fetch_assoc($result);


// ==============================
// Cek Booking Ganda
// ==============================

$sql = "SELECT id
        FROM booking
        WHERE user_id = ?
        AND jadwal_id = ?
        AND status_booking = 'Booked'";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $user_id, $jadwal_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {

    echo "<script>
            alert('Anda sudah melakukan booking pada kelas ini.');
            window.location='../dashboard.php';
          </script>";
    exit();

}


// ==============================
// Cek Kuota
// ==============================

$sql = "SELECT COUNT(*) AS total
        FROM booking
        WHERE jadwal_id = ?
        AND status_booking = 'Booked'";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $jadwal_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if ($row['total'] >= $jadwal['kuota']) {

    echo "<script>
            alert('Maaf, kuota kelas sudah penuh.');
            window.location='../dashboard.php';
          </script>";
    exit();

}


// ==============================
// Simpan Booking
// ==============================

$sql = "INSERT INTO booking
(
    user_id,
    jadwal_id,
    status_booking,
    status_pembayaran
)
VALUES
(
    ?,
    ?,
    'Booked',
    'Belum Bayar'
)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $user_id,
    $jadwal_id
);

if (!mysqli_stmt_execute($stmt)) {
    die("Booking gagal disimpan.");
}

$booking_id = mysqli_insert_id($conn);


// ==============================
// Simpan Notifikasi
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
    'Booking Berhasil',
    'Booking berhasil dibuat. Silakan upload bukti pembayaran.',
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
// Redirect ke Payment
// ==============================

header("Location: ../payment.php?id=" . $booking_id);
exit();

?>=========================

