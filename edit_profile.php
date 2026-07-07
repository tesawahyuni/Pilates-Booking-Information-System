<?php

require_once "config/session.php";
require_once "config/database.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profil</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/navbar.css">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="container">

<div class="menu-card">

<h2 style="margin-bottom:20px;color:var(--primary);">

Edit Profil

</h2>

<form action="process/profile_process.php" method="POST">

<div class="form-group">

<label>Nama Lengkap</label>

<input
type="text"
name="nama"
value="<?= $user['nama_lengkap']; ?>"
required>

</div>

<div class="form-group">

<div class="form-group">

<label>Email</label>

<input
type="email"
value="<?= $user['email']; ?>"
readonly>

<small style="color:#777;">
Email tidak dapat diubah.
</small>

</div>
<div class="form-group">

<label>Nomor HP</label>

<input
type="text"
name="hp"
value="<?= $user['no_hp']; ?>"
required>

</div>

<button class="btn">

Simpan Perubahan

</button>

</form>

</div>

</div>

<?php include "includes/navbar.php"; ?>

</body>

</html> 