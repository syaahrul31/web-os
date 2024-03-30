<?php
    // Sambungkan ke database
    require 'koneksi.php';

    // Memeriksa permintaan adalah metode post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $gender = $_POST['gender'];
        $alamat = $_POST['alamat'];
        $kota = $_POST['kota'];
        $kontak = $_POST['kontak'];
        $paypal_id = $_POST['paypal_id'];

        // Validasi input dan proses registrasi

        // Hash password sebelum disimpan di database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Query menyimpan data pelanggan
        $query = "INSERT INTO pelanggan (username, password, email, tanggal_lahir, gender, alamat, kota, kontak, paypal_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Siapkan pernyataan SQL
        $stmt = $koneksi->prepare($query);
        // Ikatkan parameter 
        $stmt->bind_param("sssssssss", $username, $hashed_password, $email, $tanggal_lahir, $gender, $alamat, $kota, $kontak, $paypal_id);

        // Jika query dieksekusi dengan sukses
        if ($stmt->execute()) {
            echo '<script>alert("Registrasi sukses. Silakan login.");</script>';
            echo '<script>window.location.href = "login.php";</script>';
            exit();
        } else {
            echo "Gagal mendaftar: " . $stmt->error;
        }
        
        // Tutup pernyataan SQL
        $stmt->close();
    }
?>
