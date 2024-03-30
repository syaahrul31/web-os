<!DOCTYPE html>
<html>
    <head>
        <title>Tambah Produk</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mt-5">Tambah Produk</h1>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="produk_add_proses.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk:</label>
                                    <input type="text" class="form-control" name="nama_produk" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi:</label>
                                    <textarea class="form-control" name="deskripsi" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga:</label>
                                    <input type="number" class="form-control" name="harga" required>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Gambar Produk:</label>
                                    <input type="file" class="form-control-file" name="gambar" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah Produk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
