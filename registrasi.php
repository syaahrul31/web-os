<!DOCTYPE html>
<html>
    <head>
        <title>Form Registrasi</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-theme.min.css">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mt-5">Form Registrasi</h1>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="registrasi_proses.php" method="post">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="retype_password">Retype Password:</label>
                                    <input type="password" class="form-control" name="retype_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                                    <input type="date" class="form-control" name="tanggal_lahir">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin:</label>
                                    <select class="form-control" name="gender">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" class="form-control" name="alamat">
                                </div>
                                <div class="form-group">
                                    <label for="kota">Kota:</label>
                                    <input type="text" class="form-control" name="kota">
                                </div>
                                <div class="form-group">
                                    <label for="kontak">Kontak:</label>
                                    <input type="text" class="form-control" name="kontak">
                                </div>
                                <div class="form-group">
                                    <label for="paypal_id">PayPal ID:</label>
                                    <input type="text" class="form-control" name="paypal_id">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Clear</button>
                            </form>
                        </div>
                    </div>
                    <p class="mt-3 text-center">Sudah memiliki akun? <a href="login.php">Login di sini</a></p>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
