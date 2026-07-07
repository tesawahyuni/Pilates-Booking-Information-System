<?php

require_once "config/session.php";
require_once "config/database.php";

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$booking_id = intval($_GET['id']);

$sql = "

SELECT

booking.id,
booking.status_booking,
booking.status_pembayaran,
booking.bukti_transfer,

kelas.nama_kelas,
kelas.harga,

jadwal.tanggal,
jadwal.jam_mulai,
jadwal.jam_selesai

FROM booking

JOIN jadwal
ON booking.jadwal_id = jadwal.id

JOIN kelas
ON jadwal.kelas_id = kelas.id

WHERE booking.id = ?

";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $booking_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = mysqli_fetch_assoc($result);

if (!$data) {
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

<title>Detail Booking</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/navbar.css">

<style>

.detail-container{

    width:90%;
    max-width:420px;
    margin:25px auto 90px;

}

.detail-card{

    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 6px 15px rgba(0,0,0,.08);

}

.detail-card h2{

    color:#2E7D32;
    margin-bottom:20px;

}

.item{

    display:flex;
    justify-content:space-between;
    margin-bottom:15px;

}

.item span{

    color:#777;

}

.status{

    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    background:#FFF4E5;
    color:#A56A00;
    font-size:13px;
    font-weight:600;

}

.success{

    background:#E8F5E9;
    color:#2E7D32;

}

img{

    width:100%;
    border-radius:12px;
    margin-top:15px;

}

.btn{

    margin-top:25px;

}

</style>

</head>

<body>

<div class="detail-container">

<div class="detail-card">

<h2>Detail Booking</h2>

<div class="item">
<span>Kelas</span>
<strong><?= $data['nama_kelas']; ?></strong>
</div>

<div class="item">
<span>Tanggal</span>
<strong><?= $data['tanggal']; ?></strong>
</div>

<div class="item">
<span>Jam</span>
<strong><?= $data['jam_mulai']; ?> - <?= $data['jam_selesai']; ?></strong>
</div>

<div class="item">
<span>Total</span>
<strong>Rp <?= number_format($data['harga']); ?></strong>
</div>

<div class="item">
<span>Status Booking</span>
<span class="status success">
<?= $data['status_booking']; ?>
</span>
</div>

<div class="item">
<span>Status Pembayaran</span>
<span class="status">
<?= $data['status_pembayaran']; ?>
</span>
</div>

<?php if(!empty($data['bukti_transfer'])){ ?>

<h4 style="margin-top:25px;">
Bukti Pembayaran
</h4>

<img src="uploads/pembayaran/<?= $data['bukti_transfer']; ?>">

<?php } ?>

<a href="dashboard.php" class="btn">
Kembali ke Dashboard
</a>

</div>

</div>

<?php include "includes/navbar.php"; ?>

</body>

</html> 