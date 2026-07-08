<?php

require_once "config/session.php";
require_once "config/database.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

// Menentukan foto profil
if (!empty($user['foto_profile']) && file_exists("assets/uploads/profile/" . $user['foto_profile'])) {
    $fotoProfile = "assets/uploads/profile/" . $user['foto_profile'];
} else {
    $fotoProfile = "assets/images/avatar-default.png";
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profil</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/navbar.css">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="container">

    <div class="profile-header">

        <!-- FOTO PROFILE -->
        <img
        src="<?= $fotoProfile; ?>"
        class="profile-photo"
        alt="Foto Profil">

        <h2>

            <?= htmlspecialchars($user['nama_lengkap']); ?>

        </h2>

        <p>

            <?= htmlspecialchars($user['email']); ?>

        </p>

    </div>

    <div class="menu-card">

        <a href="edit_profile.php">

            <i class="bi bi-person-fill"></i>

            Edit Profil

            <i class="bi bi-chevron-right"></i>

        </a>

        <a href="change_password.php">

            <i class="bi bi-lock-fill"></i>

            Ubah Password

            <i class="bi bi-chevron-right"></i>

        </a>

        <a href="history.php">

            <i class="bi bi-clock-history"></i>

            Riwayat Booking

            <i class="bi bi-chevron-right"></i>

        </a>

        <a href="logout.php" class="logout">

            <i class="bi bi-box-arrow-right"></i>

            Logout

            <i class="bi bi-chevron-right"></i>

        </a>

    </div>

</div>

<?php include "includes/navbar.php"; ?>

</body>

</html>