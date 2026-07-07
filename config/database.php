<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "pilates_booking";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi Database Gagal : " . mysqli_connect_error());
}

?>