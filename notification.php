<?php

require_once "config/session.php";
require_once "config/database.php";

$user_id = $_SESSION['user_id'];

// Ambil semua notifikasi milik user
$sql = "SELECT *
        FROM notifikasi
        WHERE user_id = ?
        ORDER BY created_at DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// Tandai semua notifikasi sebagai dibaca
$sqlUpdate = "UPDATE notifikasi
              SET status='dibaca'
              WHERE user_id=?";

$stmtUpdate = mysqli_prepare($conn, $sqlUpdate);

mysqli_stmt_bind_param(
    $stmtUpdate,
    "i",
    $user_id
);

mysqli_stmt_execute($stmtUpdate);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Notifikasi</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/navbar.css">

<style>

.container{

    width:90%;
    max-width:700px;
    margin:30px auto;
    padding-bottom:80px;

}

h2{

    margin-bottom:20px;

}

.card{

    background:#fff;
    border-radius:12px;
    padding:18px;
    margin-bottom:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);

}

.card h3{

    margin:0;
    color:#333;

}

.card p{

    margin:10px 0;
    color:#555;

}

.time{

    font-size:13px;
    color:#999;

}

.empty{

    text-align:center;
    padding:50px;
    color:#888;

}

</style>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="container">

<h2>

<i class="bi bi-bell-fill"></i>

Notifikasi

</h2>

<?php

if(mysqli_num_rows($result) == 0){

?>

<div class="empty">

<i class="bi bi-bell" style="font-size:50px;"></i>

<p>Belum ada notifikasi.</p>

</div>

<?php

}else{

while($notif = mysqli_fetch_assoc($result)){

?>

<div class="card">

<h3>

<?= htmlspecialchars($notif['judul']); ?>

</h3>

<p>

<?= htmlspecialchars($notif['isi']); ?>

</p>

<div class="time">

<?= date("d M Y H:i", strtotime($notif['created_at'])); ?>

</div>

</div>

<?php

}

}

?>

</div>

<?php include "includes/navbar.php"; ?>

</body>

</html>