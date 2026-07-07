<?php

require_once "../config/session.php";
require_once "../config/database.php";

$user_id = $_SESSION['user_id'];

$old = $_POST['old_password'];
$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

// Ambil password user
$sql = "SELECT password FROM users WHERE id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

// Cek password lama
if(!password_verify($old,$user['password'])){

    die("Password lama salah.");

}

// Cek konfirmasi password
if($new != $confirm){

    die("Konfirmasi password tidak sesuai.");

}

// Hash password baru
$password = password_hash($new,PASSWORD_DEFAULT);

// Update password
$sql = "UPDATE users SET password=? WHERE id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"si",$password,$user_id);

if(mysqli_stmt_execute($stmt)){

    echo "<script>
            alert('Password berhasil diubah.');
            window.location='../profile.php';
          </script>";
    exit();

}else{

    echo "<script>
            alert('Gagal mengubah password.');
            window.history.back();
          </script>";
    exit();

}

?>