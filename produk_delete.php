<!DOCTYPE html>
<html>
    <head>
        <title>Hapus Produk</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mt-5">Hapus Produk</h1>
            <?php
                session_start();

                // Periksa apakah pengguna sudah masuk (sudah ada sesi username)
                if (!isset($_SESSION['username'])) {
                    // Redirect ke halaman login
                    header('Location: login.php');
                    exit;
                }

                // Sambungkan ke database
                require 'koneksi.php';

                // Memeriksa permintaan adalah metode get
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    // Hapus produk jika tombol hapus di klik
                    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                        $produk_id = $_GET['id'];

                        // Hapus catatan terkait di tabel detail_pembelian
                        $query_delete_detail = "DELETE FROM detail_pembelian WHERE id_produk = ?";
                        $stmt_delete_detail = $koneksi->prepare($query_delete_detail);
                        $stmt_delete_detail->bind_param("i", $produk_id);

                        if ($stmt_delete_detail->execute()) {
                            // Catatan terkait di detail_pembelian dihapus, sekarang hapus produk
                            $query = "DELETE FROM produk WHERE id_produk = ?";
                            $stmt = $koneksi->prepare($query);
                            $stmt->bind_param("i", $produk_id);

                            // Jika query dieksekusi dengan sukses
                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success">Produk berhasil dihapus.</div>';
                            } else {
                                echo '<div class="alert alert-danger">Gagal menghapus produk.</div>';
                            }

                            // Tutup pernyataan SQL
                            $stmt->close();
                        } else {
                            echo '<div class="alert alert-danger">Gagal menghapus catatan terkait di detail_pembelian.</div>';
                        }

                        // Tutup pernyataan SQL
                        $stmt_delete_detail->close();
                    } else {
                        echo '<div class="alert alert-warning">Parameter ID produk tidak valid.</div>';
                    }
                }
            ?>
            <a href="beranda_admin.php" class="btn btn-primary">Kembali ke Beranda Admin</a>
        </div>
    </body>
</html>
