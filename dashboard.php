<?php

require_once "config/session.php";
require_once "config/database.php";

$user_id = $_SESSION['user_id'];

// Ambil data user
$sqlUser = "SELECT * FROM users WHERE id = ?";

$stmtUser = mysqli_prepare($conn, $sqlUser);

mysqli_stmt_bind_param($stmtUser, "i", $user_id);

mysqli_stmt_execute($stmtUser);

$resultUser = mysqli_stmt_get_result($stmtUser);

$user = mysqli_fetch_assoc($resultUser);

// Ambil 3 kelas unggulan
$sqlKelas = "
SELECT
    id,
    nama_kelas,
    deskripsi,
    durasi,
    level,
    harga,
    gambar
FROM kelas
LIMIT 3
";

$resultKelas = mysqli_query($conn, $sqlKelas);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Home</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/navbar.css">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="container">

    <!-- HERO -->

    <section class="hero">

        <div class="hero-text">

            <h1>

                Halo,
                <?= htmlspecialchars($user['nama_lengkap']); ?> 👋

            </h1>

            <p>

                Selamat datang di <b>Pilates Booking</b>.
                Temukan kelas pilates terbaik untuk menjaga
                kesehatan, meningkatkan fleksibilitas,
                serta memperkuat otot inti tubuh.

            </p>

            <a
            href="#kelas"
            class="btn-primary">

                Lihat Kelas

            </a>

        </div>

        <div class="hero-image">

            <img
            src="<?=
            !empty($user['foto_profile'])
            ? 'assets/uploads/profile/'.$user['foto_profile']
            : 'assets/images/avatar-default.png';
            ?>"
            alt="Foto Profile"
            class="profile-image">

        </div>

    </section>

    <!-- ABOUT -->

    <section class="about">

        <h2>

            Apa itu Pilates?

        </h2>

        <p>

            Pilates merupakan latihan fisik yang berfokus
            pada keseimbangan tubuh, fleksibilitas,
            koordinasi, postur, dan kekuatan otot inti.
            Olahraga ini cocok untuk semua kalangan,
            baik pemula maupun yang sudah berpengalaman.

        </p>

    </section>

    <!-- BENEFIT -->

    <section class="benefit">

        <h2>

            Manfaat Pilates

        </h2>

        <div class="benefit-grid">

            <div class="benefit-card">

                <i class="bi bi-heart-pulse-fill"></i>

                <h3>

                    Tubuh Lebih Sehat

                </h3>

                <p>

                    Menjaga kebugaran tubuh
                    dan meningkatkan daya tahan.

                </p>

            </div>

            <div class="benefit-card">

                <i class="bi bi-person-standing"></i>

                <h3>

                    Postur Ideal

                </h3>

                <p>

                    Membantu memperbaiki
                    postur tubuh menjadi lebih baik.

                </p>

            </div>

            <div class="benefit-card">

                <i class="bi bi-lightning-charge-fill"></i>

                <h3>

                    Otot Inti

                </h3>

                <p>

                    Menguatkan otot inti
                    agar tubuh lebih stabil.

                </p>

            </div>

            <div class="benefit-card">

                <i class="bi bi-emoji-smile-fill"></i>

                <h3>

                    Mengurangi Stres

                </h3>

                <p>

                    Memberikan efek relaksasi
                    dan meningkatkan kualitas hidup.

                </p>

            </div>

        </div>

    </section>

    <!-- KELAS UNGGULAN -->

    <section
    class="class-section"
    id="kelas">

        <div class="title-row">

            <h2>

                Kelas Pilates

            </h2>

        </div>

        <div class="class-grid">

        <?php while($kelas = mysqli_fetch_assoc($resultKelas)){ ?>

            <div class="class-card">

                <img
                src="assets/images/class/<?= $kelas['gambar']; ?>"
                class="class-image">

                <div class="class-content">

                    <h3>

                        <?= htmlspecialchars($kelas['nama_kelas']); ?>

                    </h3>

                    <p>

                        <?= htmlspecialchars($kelas['deskripsi']); ?>

                    </p>

                    <div class="info">

                        <span>

                            <i class="bi bi-clock-fill"></i>

                            <?= $kelas['durasi']; ?> Menit

                        </span>

                    </div>

                    <div class="info">

                        <span>

                            <i class="bi bi-bar-chart-fill"></i>

                            <?= htmlspecialchars($kelas['level']); ?>

                        </span>

                    </div>

                    <div class="price">

                        Rp <?= number_format($kelas['harga'],0,",","."); ?>

                    </div>

                </div>

            </div>

        <?php } ?>         </div>

</div>

<?php include "includes/navbar.php"; ?>

</body>

</html>