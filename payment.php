<?php


require_once "config/session.php";
require_once "config/database.php";

if(!isset($_GET['id'])){
    header("Location: dashboard.php");
    exit();
}

$booking_id = intval($_GET['id']);

$sql = "
SELECT

booking.id,

kelas.nama_kelas,

kelas.harga,

jadwal.tanggal,

jadwal.jam_mulai,

jadwal.jam_selesai,

booking.status_pembayaran

FROM booking

JOIN jadwal
ON booking.jadwal_id = jadwal.id

JOIN kelas
ON jadwal.kelas_id = kelas.id

WHERE booking.id = ?

";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$booking_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = mysqli_fetch_assoc($result);

if(!$data){

    header("Location: dashboard.php");
    exit();

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Pembayaran</title>

<link rel="stylesheet" href="css/style.css?v=1">
<link rel="stylesheet" href="css/payment.css?v=1">
<link rel="stylesheet" href="css/navbar.css?v=1">
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="payment-container">

    <h2>Konfirmasi Booking</h2>
    <p class="subtitle">
        Silakan lakukan pembayaran untuk menyelesaikan booking kelas Anda.
    </p>

    <div class="card">

        <h3>Ringkasan Booking</h3>

        <div class="info-row">
            <span>Kelas</span>
            <strong><?= $data['nama_kelas']; ?></strong>
        </div>

        <div class="info-row">
            <span>Tanggal</span>
            <strong><?= $data['tanggal']; ?></strong>
        </div>

        <div class="info-row">
            <span>Jam</span>
            <strong>
                <?= $data['jam_mulai']; ?>
                -
                <?= $data['jam_selesai']; ?>
            </strong>
        </div>

        <div class="info-row total">
            <span>Total Pembayaran</span>
            <strong>
                Rp <?= number_format($data['harga']); ?>
            </strong>
        </div>

    </div>

    <div class="card">

        <h3>Metode Pembayaran</h3>

        <div class="bank-box">

            <h4>Transfer Bank BCA</h4>

            <p><b>Nomor Rekening</b></p>

            <h2>1234567890</h2>

            <p>a.n Pilates Booking Studio</p>

        </div>

        <div class="warning">

            <i class="bi bi-info-circle"></i>

            Setelah melakukan transfer,
            silakan upload bukti pembayaran.

        </div>

    </div>

    <div class="card">

        <form
            action="process/payment_process.php"
            method="POST"
            enctype="multipart/form-data">

            <input
                type="hidden"
                name="booking_id"
                value="<?= $booking_id; ?>">

            <label>Upload Bukti Transfer</label>

            <input
                type="file"
                name="bukti"
                accept=".jpg,.jpeg,.png"
                required>

            <button
                class="btn-payment"
                type="submit">

                Kirim Bukti Pembayaran

            </button>

        </form>

    </div>

</div>

<?php include "includes/navbar.php"; ?>

</body>

</html>