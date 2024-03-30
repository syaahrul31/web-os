<!DOCTYPE html>
<html>
    <head>
        <title>Edit Produk</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mt-5">Edit Produk</h1>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            // Sambungkan ke database
                            require 'koneksi.php';

                            if (isset($_GET['id'])) {
                                $id_produk = $_GET['id'];

                                // Query untuk mengambil data produk berdasarkan ID
                                $query = "SELECT * FROM produk WHERE id_produk = ?";
                                // Siapkan pernyataan SQL
                                $stmt = $koneksi->prepare($query);
                                // Ikatkan parameter (ID produk)
                                $stmt->bind_param("i", $id_produk);
                                // Eksekusi pernyataan SQL
                                $stmt->execute();   
                              
                                $result = $stmt->get_result();
                                $produk = $result->fetch_assoc();
                                
                                // Tutup pernyataan SQL
                                $stmt->close();
                            }
                            ?>

                            <form action="produk_edit_proses.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk:</label>
                                    <input type="text" class="form-control" name="nama_produk" value="<?= $produk['nama_produk']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi:</label>
                                    <textarea class="form-control" name="deskripsi" required><?= $produk['deskripsi']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga:</label>
                                    <input type="number" class="form-control" name="harga" value="<?= $produk['harga']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Gambar Produk:</label>
                                    <input type="file" class="form-control-file" name="gambar">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
