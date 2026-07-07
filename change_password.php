<?php

require_once "config/session.php";
require_once "config/database.php";

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ubah Password</title>

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

Ubah Password

</h2>

<form action="process/change_password_process.php" method="POST">

<div class="form-group">

<label>Password Lama</label>

<input
type="password"
name="old_password"
required>

</div>

<div class="form-group">

<label>Password Baru</label>

<input
type="password"
name="new_password"
required>

</div>

<div class="form-group">

<label>Konfirmasi Password Baru</label>

<input
type="password"
name="confirm_password"
required>

</div>

<button class="btn">

Simpan Password

</button>

</form>

</div>

</div>

<?php include "includes/navbar.php"; ?>

</body>

</html>