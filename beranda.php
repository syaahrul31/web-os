<!DOCTYPE html>
<html>
    <head>
        <title>Jaddid Market 2023</title>
        <!-- Tautan ke file CSS Bootstrap dan tema -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-theme.min.css">
    </head>
    <body>
        <header class="container mt-5">
            <h1>Selamat Datang di Jaddid Market</h1>
            <p>Temukan produk-produk berkualitas dengan harga terbaik.</p>
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
                            echo '<li class="nav-item"><a class="nav-link" href="keranjang.php"> Keranjang </a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="logout.php"> Logout </a></li>';
                        } 
                    ?>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="container mt-4">
            <h2 class="mb-3">Daftar Produk</h2>
            <div class="row">
            <?php
                //Sambungkan ke database
                require 'koneksi.php';
                // Dapatkan data produk dari database
                $query = "SELECT * FROM produk";
                //Periksa untuk memastikan data query tersedia
                $result = $koneksi->query($query);

                if ($result->num_rows > 0) {
                    // Loop untuk menampilkan data produk
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-3 mb-3">';
                        echo '<div class="card">';
                        echo '<img class="card-img-top" src="img/'.$row['gambar'].'" alt="'.$row['nama_produk'].'">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title"> '.$row['nama_produk'].' </h5>';
                        echo '<p class="card-text"> '.$row['deskripsi'].' </p>';
                        echo '<p class="card-text"> Harga: Rp. '.number_format($row['harga'], 0, '.', ',').' </p>';
                        echo '<div class="input-group">';
                        echo '<input class="form-control jumlah-produk" type="number" value="1">';
                        echo '<div class="input-group-append">';
                        echo '<a class="btn btn-primary beli-btn" data-id="'.$row['id_produk'].'" data-nama="'.$row['nama_produk'].'"> Beli </a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "Tidak ada produk yang tersedia.";
                }

                // Tutup koneksi ke database
                $koneksi->close(); 
            ?>
            </div>
        </section>

        <footer class="container mt-5">
            <p>&copy; 2023 Jaddid Market</p>
        </footer>

        <!-- Tautan ke file JavaScript Bootstrap dan jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // Menangani pengklikan tombol beli
            $(document).ready(function() {
                $('.beli-btn').click(function(e) {
                    e.preventDefault();

                    // Dapatkan ID produk dari atribut data
                    var id_produk = $(this).data('id');
                    // Dapatkan jumlah produk dari input jumlah-produk
                    var jumlah_produk = parseInt($(this).closest('.card-body').find('.jumlah-produk').val());
                    // Kirim permintaan AJAX untuk tambah produk ke keranjang
                    $.ajax({
                        type: 'POST',
                        url: 'tambah_ke_keranjang.php',
                        data: { produk_id: id_produk, jumlah: jumlah_produk },
                        success: function(response) {
                            if (response === 'sukses') {
                                window.location.href = 'keranjang.php';
                            } else {
                                alert('Gagal menambahkan produk ke keranjang.');
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>
