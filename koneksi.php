<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "web_oss";

    // Membuat koneksi ke database
    $koneksi = new mysqli($host, $username, $password, $database);

    // Periksa koneksi
    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $koneksi->connect_error);
    }
?>
