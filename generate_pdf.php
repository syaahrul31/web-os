<?php
    // Sambungkan library FPDF
    require 'fpdf/fpdf.php';
    // Sambungkan ke database
    require 'koneksi.php'; 

    session_start();

    if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
        $barang = $_SESSION['keranjang'];

        // Dapatkan pilihan metode pembayaran dari keranjang
        $cara_bayar = isset($_SESSION['cara_bayar']) ? $_SESSION['cara_bayar'] : 'prepaid';

        // Membuat objek PDF
        $pdf = new FPDF();
        
        // Membuat dua kolom pada setiap halaman
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();
        
        // Membuat header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 8, 'Jaddid Market', 0, 1, 'C');
        $pdf->Cell(190, 8, 'Laporan Belanja Anda', 0, 1, 'C');
        $pdf->Cell(190, 5, '', 0, 1, 'C');
        
        // Informasi pembeli
        $userID = $_SESSION['user_id'];
        $query = "SELECT * FROM pelanggan WHERE id = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();        
            $pdf->SetFont('Arial', '', 12);
            
            // Kolom pertama
            $pdf->Cell(90, 8, 'User ID      : ' . $row['id'], 0, 0, 'L');
            $pdf->Cell(90, 8, 'Tanggal          : ' . date('Y-m-d'), 0, 1, 'L');
            $pdf->Cell(90, 8, 'Nama        : ' . $row['username'], 0, 0, 'L');
            $pdf->Cell(90, 8, 'ID Paypal        : ' . $row['paypal_id'], 0, 1, 'L');
            $pdf->Cell(90, 8, 'Alamat      : ' . $row['alamat'], 0, 0, 'L');
            $pdf->Cell(90, 8, 'Nama Bank     : Bank Cemara', 0, 1, 'L');
            $pdf->Cell(90, 8, 'Kontak      : ' . $row['kontak'], 0, 0, 'L');
            $pdf->Cell(90, 8, 'Cara Bayar      : ' . ucfirst($cara_bayar), 0, 1, 'L');
            $pdf->Cell(190, 5, '', 0, 1, 'L');

            // Tabel Daftar barang
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(10, 7, 'No', 1);
            $pdf->Cell(60, 7, 'Nama Produk', 1);
            $pdf->Cell(40, 7, 'Harga', 1);
            $pdf->Cell(40, 7, 'Jumlah', 1);
            $pdf->Cell(40, 7, 'Subtotal', 1);
            $pdf->Ln(); // Pindah ke baris berikutnya

            // Menampilkan Daftar barang
            $pdf->SetFont('Arial', '', 12);
            $no = 1;
            $total_harga = 0;
            foreach ($barang as $item) {
                $subtotal = $item['harga'] * $item['jumlah'];
                $pdf->Cell(10, 7, $no, 1);
                $pdf->Cell(60, 7, $item['nama_produk'], 1);
                $pdf->Cell(40, 7, 'Rp. ' . number_format($item['harga'], 2), 1);
                $pdf->Cell(40, 7, $item['jumlah'], 1);
                $pdf->Cell(40, 7, 'Rp. ' . number_format($subtotal, 2), 1);
                $pdf->Ln();
                $no++;
                $total_harga += $subtotal;
            }

            // Menampilkan total harga
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(150, 7, 'Total Belanja (Termasuk Pajak)', 1);
            $pdf->Cell(40, 7, 'Rp. ' . number_format($total_harga, 2), 1);

            // Tanda tangan toko
            $pdf->Ln(10); // Spasi sebelum tanda tangan
            $pdf->Cell(190, 10, 'Tanda Tangan Toko', 0, 1, 'R');
        }

        // Output PDF
        $pdf->Output();
    } else {
        echo 'Keranjang belanja kosong.';
    }
?>
