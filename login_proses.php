<?php
    //Sambungkan ke Database
    require 'koneksi.php'; 

    session_start();

    // Memeriksa permintaan adalah metode post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userID = $_POST['userID'];
        $password = $_POST['password'];

        // Mengekstrak data masukan dari form login

        // Query memeriksa pengguna berdasarkan nama pengguna
        $query = "SELECT id, username, password, role FROM pelanggan WHERE username = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("s", $userID);

        // Jika query dieksekusi dengan sukses
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            // Jika data pengguna ditemukan dalam database
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                
                // Jika kata sandi sesuai
                if (password_verify($password, $row['password'])) {
                    
                    // Jika pengguna adalah admin
                    if ($row['role'] == 'admin') {
                        // Admin login, set session
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['role'] = true;
                        // Redirect ke halaman beranda admin
                        header('Location: beranda_admin.php');
                    } else {
                        //Jika pengguna adalah pelanggan
                        // Pengguna biasa login, set session
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        // Redirect ke halaman beranda
                        header('Location: beranda.php');
                    }

                } else {
                    // Jika kata sandi tidak sesuai
                    echo '<script>alert("Kata sandi salah.");</script>';
                    echo '<script>window.location.href = "login.php";</script>';
                    exit();
                }

            } else {
                //Jika data pengguna tidak ditemukan dalam database
                echo '<script>alert("User ID tidak ditemukan.");</script>';
                echo '<script>window.location.href = "login.php";</script>';
                exit();
            }

        } else {
            // Jika query gagal eksekusi
            echo "Gagal login: " . $stmt->error;
        }

        // Tutup pernyataan SQL
        $stmt->close();
    }
?>
