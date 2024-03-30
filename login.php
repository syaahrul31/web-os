<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Login</title>
        <!-- Tautan ke file CSS Bootstrap dan tema Bootswatch -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/superhero.css"> <!-- Tautan ke tema Bootswatch -->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 mt-5">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h1 class="text-center">Selamat Datang</h1>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="img/logo.png" alt="Jaddid Market" style="max-width: 250px;">
                            </div>
                            <form action="login_proses.php" method="post">
                                <div class="form-group">
                                    <label for="userID">User ID:</label>
                                    <input type="text" class="form-control" name="userID" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-dark btn-block">Login</button>
                            </form>
                        </div>
                    </div>
                    <p class="mt-3 text-center">Belum memiliki akun? <a href="registrasi.php">Daftar di sini</a></p>
                </div>
            </div>
        </div>
        <!-- Tautan ke file JavaScript Bootstrap -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
