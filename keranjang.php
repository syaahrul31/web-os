<!DOCTYPE html>
<html>
    <head>
        <title>Keranjang Belanja</title>
        <!-- Tautan ke file CSS Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mt-5">Keranjang Belanja</h1>
            <a href="beranda.php" class="btn btn-primary mb-3"> < </a>
            <a href="keranjang.php?checkout=true" class="btn btn-success mb-3" target="_blank">Check Out</a>
            
            <form method="POST" id="caraBayarForm">
                <select class="form-control" name="cara_bayar" id="cara_bayar">
                    <option value="" id="label">Metode Pembayaran</option>
                    <option value="prepaid">Prepaid</option>
                    <option value="postpaid">Postpaid</option>
                </select>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>ID Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    session_start();
                        
                    // Sambungkan ke database
                    require 'koneksi.php';

                    // Inisialisasi keranjang belanja jika belum ada
                    if (!isset($_SESSION['keranjang'])) {
                            $_SESSION['keranjang'] = array();
                    }

                    // Tambah produk ke keranjang jika tombol Beli di klik
                    if (isset($_GET['beli']) && is_numeric($_GET['beli'])) {
                        $produk_id = $_GET['beli'];
                        $query_produk = "SELECT * FROM produk WHERE id_produk = $produk_id";
                        $result_produk = $koneksi->query($query_produk);

                        if ($result_produk->num_rows > 0) {
                            $row_produk = $result_produk->fetch_assoc();
                            $keranjang_item = array(
                                'id' => $row_produk['id_produk'],
                                'nama_produk' => $row_produk['nama_produk'],
                                'jumlah' => 1,
                                'harga' => $row_produk['harga']
                            );
                            // Tambahkan produk ke keranjang
                            array_push($_SESSION['keranjang'], $keranjang_item);
                        }
                    }

                    // Simpan metode pembayaran yang dipilih
                    if (isset($_POST['cara_bayar'])) {
                        $_SESSION['cara_bayar'] = $_POST['cara_bayar'];
                    }

                    // Tampilkan produk dalam keranjang
                    if (!empty($_SESSION['keranjang'])) {
                        $total_harga = 0;
                        foreach ($_SESSION['keranjang'] as $index => $item) {
                            $harga_total = $item['harga'] * $item['jumlah'];
                            $total_harga += $harga_total;
                            echo '<tr>';
                            echo '<td> '.($index + 1).' </td>';
                            echo '<td> '.$item['nama_produk'].' </td>';                                
                            echo '<td> '.$item['id'].' </td>';
                            echo '<td> '.$item['jumlah'].' </td>';
                            echo '<td> Rp. '.number_format($harga_total, 0, '.', ',').' </td>';
                            echo '<td><a href="keranjang.php?hapus='.$index.'" class="btn btn-danger">Hapus</a></td>';
                            echo '</tr>';
                        }
                        echo '<tr>';
                        echo '<td colspan="4" class="text-right"> Total Harga Keseluruhan (Termasuk Pajak) : </td>';
                        echo '<td><strong> Rp. '.number_format($total_harga, 0, '.', ',').' </strong></td>';                            
                        echo '</tr>';
                    } else {
                        echo '<tr>';
                        echo '<td colspan="5">Keranjang belanja kosong.</td>';
                        echo '</tr>';
                    }

                    // Hapus produk dari keranjang
                    if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
                        $index = $_GET['hapus'];
                        
                        if (isset($_SESSION['keranjang'][$index])) {
                            unset($_SESSION['keranjang'][$index]);
                        }
                        // Redirect kembali ke halaman keranjang
                        header('Location: keranjang.php'); 
                    }

                    // Proses checkout
                    if (isset($_GET['checkout']) && !empty($_SESSION['keranjang'])) {
                        $id_pelanggan = $_SESSION['user_id'];
                        $tanggal_checkout = date('Y-m-d');

                        // Hitung total harga
                        $total_harga = 0;
                        foreach ($_SESSION['keranjang'] as $item) {
                            $total_harga += $item['harga'] * $item['jumlah'];
                        }

                        // Simpan data checkout ke database
                        $query_checkout = "INSERT INTO checkout (id_pelanggan, tanggal_checkout, total_harga) VALUES (?, ?, ?)";
                        $stmt = $koneksi->prepare($query_checkout);
                        $stmt->bind_param("iss", $id_pelanggan, $tanggal_checkout, $total_harga);
                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                            // Dapatkan ID checkout yang baru saja dibuat
                            $checkout_id = $stmt->insert_id;
                            // Simpan detail barang-barang yang dibeli
                            $query_detail_pembelian = "INSERT INTO detail_pembelian (id_checkout, id_produk, jumlah) VALUES (?, ?, ?)";
                            $stmt_detail_pembelian = $koneksi->prepare($query_detail_pembelian);

                            foreach ($_SESSION['keranjang'] as $item) {
                                $id_produk = $item['id'];
                                $jumlah = $item['jumlah'];
                                $stmt_detail_pembelian->bind_param("iii", $checkout_id, $id_produk, $jumlah);
                                $stmt_detail_pembelian->execute();
                            }

                            // Redirect ke halaman faktur
                            header('Location: generate_pdf.php');
                        } else {
                            echo 'Gagal melakukan checkout.';
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Tautan ke file JavaScript Bootstrap -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                // Menyimpan opsi pembayaran yang dipilih
                var caraBayar = "<?php echo isset($_SESSION['cara_bayar']) ? $_SESSION['cara_bayar'] : ''; ?>";
                $('#cara_bayar').val(caraBayar);

                // Submit form saat opsi pembayaran berubah
                $('#cara_bayar').change(function() {
                    $('#caraBayarForm').submit();
                });

                // Menampilkan/menghilangkan label opsi pembayaran
                $('#cara_bayar').click(function() {
                    var label = $('#label');
                    if ($(this).data('active') === 'true') {
                        label.show();
                        $(this).data('active', 'false');
                    } else {
                        label.hide();
                        $(this).data('active', 'true');
                    }
                });
            });
        </script>
    </body>
</html>
