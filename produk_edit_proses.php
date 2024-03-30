<?php
// Sambungkan ke database
require 'koneksi.php'; 

// Memeriksa permintaan adalah metode post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // Handling upload gambar

    $gambar = null;

    // Memeriksa ada file gambar yang diunggah melalui form
    if (isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0) {
        $gambar = $_FILES['gambar']['name'];
        $temp_file = $_FILES['gambar']['tmp_name'];
        
        // Direktori penyimpanan gambar akan diperbarui
        $upload_directory = "img/"; 
         // Tentukan path gambar
        $target_file = $upload_directory . basename($gambar);
        
        // Jika gambar dipindahkan dari temporary ke direktori tujuan
        if (move_uploaded_file($temp_file, $target_file)) {
            // Update data produk ke database
            $query = "UPDATE produk SET nama_produk=?, deskripsi=?, harga=?, gambar=? WHERE id_produk=?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("ssdsi", $nama_produk, $deskripsi, $harga, $gambar, $id_produk);
        } else {
            echo "Gagal mengunggah gambar.";
        }
    } else {
        // Jika tidak ada gambar yang diunggah, tidak perlu mengubah nama gambar
        $query = "UPDATE produk SET nama_produk=?, deskripsi=?, harga=? WHERE id_produk=?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ssdi", $nama_produk, $deskripsi, $harga, $id_produk);
    }
    
    // Jika query dieksekusi dengan sukses
    if ($stmt->execute()) {
        // Produk berhasil diubah, alihkan ke halaman lain jika perlu
        header('Location: beranda_admin.php');
    } else {
        echo "Gagal mengubah produk.";
    }
}
?>
