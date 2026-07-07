<?php

require_once "config/session.php";
require_once "config/database.php";


// Ambil semua jadwal yang tersedia

$sql = "
SELECT
    jadwal.id,
    kelas.nama_kelas,
    kelas.deskripsi,
    kelas.durasi,
    kelas.level,
    kelas.harga,
    kelas.gambar,

    instruktur.nama AS instruktur,

    jadwal.tanggal,
    jadwal.jam_mulai,
    jadwal.jam_selesai,
    jadwal.kuota

FROM jadwal

JOIN kelas
ON jadwal.kelas_id = kelas.id

JOIN instruktur
ON jadwal.instruktur_id = instruktur.id

ORDER BY jadwal.tanggal ASC
";


$result = mysqli_query($conn,$sql);


?>


<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">


<title>Booking Kelas</title>


<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/booking.css">


<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


</head>


<body>


<div class="container">


<h2 class="section-title">

Jadwal Pilates

</h2>


<p style="margin-bottom:20px;color:#777;">

Pilih kelas pilates yang ingin kamu ikuti.

</p>



<?php while($jadwal = mysqli_fetch_assoc($result)){ ?>


<div class="booking-card">



<?php if(!empty($jadwal['gambar'])){ ?>

<img

src="assets/images/class/<?= $jadwal['gambar']; ?>"

class="booking-image">


<?php } ?>



<h2>

<?= htmlspecialchars($jadwal['nama_kelas']); ?>

</h2>



<p>

<?= htmlspecialchars($jadwal['deskripsi']); ?>

</p>



<div class="booking-info">

<i class="bi bi-person-fill"></i>

Instruktur :

<?= htmlspecialchars($jadwal['instruktur']); ?>

</div>



<div class="booking-info">

<i class="bi bi-calendar-event-fill"></i>

<?= date(
"d M Y",
strtotime($jadwal['tanggal'])
); ?>

</div>



<div class="booking-info">

<i class="bi bi-clock-fill"></i>

<?= substr($jadwal['jam_mulai'],0,5); ?>

-

<?= substr($jadwal['jam_selesai'],0,5); ?>


</div>



<div class="booking-info">

<i class="bi bi-bar-chart-fill"></i>

Level :

<?= htmlspecialchars($jadwal['level']); ?>


</div>



<div class="booking-info">

<i class="bi bi-hourglass-split"></i>

Durasi :

<?= $jadwal['durasi']; ?>

Menit


</div>



<div class="booking-info">

<i class="bi bi-people-fill"></i>

Kuota :

<?= $jadwal['kuota']; ?>

Orang


</div>



<div class="booking-price">

Rp <?= number_format(
$jadwal['harga'],
0,
",",
"."
); ?>


</div>




<form

action="process/booking_process.php"

method="POST">


<input

type="hidden"

name="jadwal_id"

value="<?= $jadwal['id']; ?>">



<button

type="submit"

class="btn">


Booking Sekarang


</button>


</form>



</div>


<?php } ?>


</div>



<?php include "includes/navbar.php"; ?>


</body>

</html> 