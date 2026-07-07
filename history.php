<?php

require_once "config/session.php";
require_once "config/database.php";

$user_id = $_SESSION['user_id'];

$sql = "

SELECT

booking.id,

kelas.nama_kelas,

jadwal.tanggal,

jadwal.jam_mulai,

booking.status_booking,

booking.status_pembayaran

FROM booking

JOIN jadwal
ON booking.jadwal_id=jadwal.id

JOIN kelas
ON jadwal.kelas_id=kelas.id

WHERE booking.user_id=?

ORDER BY booking.id DESC

";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$user_id);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Riwayat Booking</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/history.css">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="container">

<h2 class="page-title">

<i class="bi bi-clock-history"></i>

Riwayat Booking

</h2>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<div class="history-card">

<h3>

<?= $row['nama_kelas']; ?>

</h3>

<p>

<i class="bi bi-calendar-event"></i>

<?= $row['tanggal']; ?>

</p>

<p>

<i class="bi bi-clock"></i>

<?= $row['jam_mulai']; ?>

</p>

<p>

Status Booking :

<strong>

<?= $row['status_booking']; ?>

</strong>

</p>

<p>

Status Pembayaran :

<strong>

<?= $row['status_pembayaran']; ?>

</strong>

</p>

</div>

<?php } ?>

<?php if(mysqli_num_rows($result)==0){ ?>

<div class="empty-card">

<i class="bi bi-calendar-x"></i>

<p>

Belum ada riwayat booking.

</p>

</div>

<?php } ?>

</div>
<a href="profile.php" class="btn back-profile">

    <i class="bi bi-arrow-left"></i>

    Kembali ke Profil

</a>
<?php include "includes/navbar.php"; ?>

</body>

</html> 