<?php
    session_start();
    
    // Periksa apakah pengguna sudah masuk (sudah ada sesi username)
    if (!isset($_SESSION['username'])) {
        // Redirect ke halaman login
        header('Location: login.php');
        exit;
    }

    // Memeriksa permintaan adalah metode post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sambungkan ke database
        require 'koneksi.php';

        $id_produk = $_POST['id_produk'];

        // Gunakan prepared statement untuk menghindari SQL Injection
        $query = "DELETE FROM produk WHERE id_produk = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id_produk);

        // Jika query dieksekusi dengan sukses
        if ($stmt->execute()) {
            echo "Produk berhasil dihapus.";
        } else {
            echo "Error: Gagal menghapus produk.";
        }

        // Tutup pernyataan SQL
        $stmt->close();
    }
?>

