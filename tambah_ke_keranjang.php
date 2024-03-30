<?php
    session_start();

    // Sambungkan ke database
    require 'koneksi.php';

    if (isset($_POST['produk_id']) && isset($_POST['jumlah'])) {
        $produk_id = $_POST['produk_id'];
        $jumlah = $_POST['jumlah'];

        // Query untuk mengambil data produk berdasarkan ID
        $query_produk = "SELECT * FROM produk WHERE id_produk = ?";
        $stmt = $koneksi->prepare($query_produk);
        $stmt->bind_param("i", $produk_id);
        $stmt->execute();
        $result_produk = $stmt->get_result();

        if ($result_produk->num_rows > 0) {
            $row_produk = $result_produk->fetch_assoc();

            // Data produk ditemukan, tambahkan ke keranjang
            $keranjang_item = array(
                'id' => $row_produk['id_produk'],
                'nama_produk' => $row_produk['nama_produk'],
                'jumlah' => $jumlah,
                'harga' => $row_produk['harga']
            );

            // Inisialisasi keranjang belanja jika belum ada
            if (!isset($_SESSION['keranjang'])) {
                $_SESSION['keranjang'] = array();
            }

            // Tambahkan produk ke keranjang
            array_push($_SESSION['keranjang'], $keranjang_item);

            echo 'sukses';
        } else {
            echo 'Produk tidak ditemukan.';
        }
    } else {
        echo 'Data tidak lengkap.';
    }
?>
