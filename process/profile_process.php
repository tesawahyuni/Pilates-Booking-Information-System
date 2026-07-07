<?php

require_once "../config/session.php";
require_once "../config/database.php";


$user_id = $_SESSION['user_id'];


// Ambil data dari form

$nama = $_POST['nama'];
$hp   = $_POST['hp'];


// Validasi

if(empty($nama) || empty($hp)){

    die("Semua data wajib diisi.");

}


// Update data user

$sql = "
UPDATE users
SET
nama_lengkap = ?,
no_hp = ?

WHERE id = ?
";


$stmt = mysqli_prepare($conn,$sql);


mysqli_stmt_bind_param(
    $stmt,
    "ssi",
    $nama,
    $hp,
    $user_id
);



if(mysqli_stmt_execute($stmt)){


    header("Location: ../profile.php");

    exit();


}else{


    die("Gagal memperbarui profil.");

}


?>