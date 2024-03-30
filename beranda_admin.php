<!DOCTYPE html>
<html>
    <head>
        <title>Admin Jaddid Market</title>
        <!-- Tautan ke file CSS Bootstrap dan tema -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-theme.min.css">
    </head>
    <body>
        <header class="container mt-5">
            <h1>Selamat Datang di Jaddid Market</h1>
            <p>Kelola Data Produk Penjualan</p>
        </header>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand">Jaddid Market</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                    <?php
                        session_start();

                        // Periksa apakah pengguna sudah masuk (sudah ada sesi username)
                        if (isset($_SESSION['username'])) {
                            // Sambungkan ke database
                            require 'koneksi.php';
                            // Dapatkan ID pengguna dari sesi
                            $userID = $_SESSION['user_id'];
                            // Dapatkan nama pengguna
                            $query = "SELECT username FROM pelanggan WHERE id = ?";
                            // Siapkan pernyataan SQL
                            $stmt = $koneksi->prepare($query);
                            // Ikatkan parameter (ID pengguna)
                            $stmt->bind_param("i", $userID);
                            // Eksekusi pernyataan SQL
                            $stmt->execute();   
                            // Ikatkan hasil ke variabel
                            $stmt->bind_result($username);
                            // Ambil hasil
                            $stmt->fetch();
                            // Tutup pernyataan SQL
                            $stmt->close();
                            // Tampilkan tautan menu yang sesuai
                            echo '<li class="nav-item"><a class="nav-link" href="profil.php">' . $username . '</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="logout.php"> Logout </a></li>';
                        } 
                    ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <br>
            <a href="produk_add.php" class="btn btn-success mb-3">Tambah Produk Baru</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Sambungkan ke database
                    require 'koneksi.php'; 
                    // Query untuk mengambil data produk
                    $query = "SELECT * FROM produk";
                    $result = $koneksi->query($query);

                    if ($result->num_rows > 0) {
                        // Loop untuk menampilkan data produk
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td> '.$row['id_produk'].' </td>';
                            echo '<td> '.$row['nama_produk'].' </td>';
                            echo '<td> '.$row['deskripsi'].' </td>';
                            echo '<td> Rp. '.number_format($row['harga'], 0, '.', ',').' </td>';
                            echo '<td> <img src="img/'.$row['gambar'].'" style="max-width:100px;"></td>';
                            echo '<td>';
                            echo '<a href="produk_edit.php?id='.$row['id_produk'].'" class="btn btn-warning"> Edit </a>';
                            echo '<a href="produk_delete.php?id='.$row['id_produk'].'" class="btn btn-danger ml-2"> Hapus </a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr>';
                        echo '<td colspan="6"> Tidak ada produk yang tersedia. </td>';
                        echo '</tr>';
                    }

                    // Tutup koneksi ke database
                    $koneksi->close(); 
                ?>
                </tbody>
            </table>
        </div>

        <footer class="container mt-5">
            <p>&copy; 2023 Jaddid Market</p>
        </footer>
    </body>
</html>
