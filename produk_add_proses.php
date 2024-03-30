<?php
    // Sambungkan ke database
    require 'koneksi.php'; 

    // Memeriksa permintaan adalah metode post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];

        // Handling upload gambar
        
        // Memeriksa ada file gambar yang diunggah melalui form
        if (isset($_FILES['gambar'])) {
            // Mengambil nama gambar
            $gambar = $_FILES['gambar']['name'];
            // Mengambil lokasi sementara gambar
            $temp_file = $_FILES['gambar']['tmp_name'];
            // Direktori penyimpanan gambar akan diunggah
            $upload_directory = "img/"; 
            // Tentukan path gambar
            $target_file = $upload_directory . basename($gambar);
            
            // Jika gambar dipindahkan dari temporary ke direktori tujuan
            if (move_uploaded_file($temp_file, $target_file)) {
                // Simpan data produk ke database
                $query = "INSERT INTO produk (nama_produk, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)";
                $stmt = $koneksi->prepare($query);
                $stmt->bind_param("ssds", $nama_produk, $deskripsi, $harga, $gambar);
                
                // Jika query dieksekusi dengan sukses
                if ($stmt->execute()) {
                    // Redirect ke beranda admin
                    header('Location: beranda_admin.php');
                } else {
                    echo "Gagal menambahkan produk.";
                }
            } else {
                echo "Gagal mengunggah gambar.";
            }
        }
    }
?>
