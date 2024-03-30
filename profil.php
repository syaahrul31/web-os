<?php
    session_start();
    // Periksa apakah sesi pengguna telah diinisialisasi
    if (!isset($_SESSION['username'])) {
        // Jika belum, redirect ke halaman login
        header('Location: login.php');
        exit;
    }
    
    // Sambungkan ke database
    require 'koneksi.php';
    // Dapatkan ID pengguna dari sesi
    $userID = $_SESSION['user_id'];
    // Dapatkan data pengguna dari database
    $query = "SELECT * FROM pelanggan WHERE id = ?";
    // Siapkan pernyataan SQL
    $stmt = $koneksi->prepare($query);
    // Ikatkan parameter (ID pengguna)
    $stmt->bind_param("i", $userID);
    // Eksekusi pernyataan SQL
    $stmt->execute();   
    
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    // Isi variabel-variabel dengan data pengguna dari database
    $username = $userData['username'];
    $email = $userData['email'];
    $tanggal_lahir = $userData['tanggal_lahir'];
    $gender = $userData['gender'];
    $alamat = $userData['alamat'];
    $kota = $userData['kota'];
    $kontak = $userData['kontak'];
    $paypal_id = $userData['paypal_id'];
    $role = $userData['role'];

    // Tutup pernyataan SQL
    $stmt->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Profil Pengguna</title>
        <!-- Tautan ke file CSS Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1 class="mt-5">Profil Pengguna</h1>
            <p>Username: <?php echo $username; ?></p>
            <p>Email: <?php echo $email; ?></p>
            <p>Tanggal Lahir: <?php echo $tanggal_lahir; ?></p>
            <p>Gender: <?php echo $gender; ?></p>
            <p>Alamat: <?php echo $alamat; ?></p>
            <p>Kota: <?php echo $kota; ?></p>
            <p>Kontak: <?php echo $kontak; ?></p>
            <p>Paypal ID: <?php echo $paypal_id; ?></p>
            <p>Role: <?php echo $role; ?></p>
            <?php
                if ($role == 'user') {
                    echo '<a href="beranda.php" class="btn btn-primary">Back</a>';
                } elseif ($role == 'admin') {
                    echo '<a href="beranda_admin.php" class="btn btn-primary">Back</a>';
                }
            ?>
        </div>
    </body>
</html>
