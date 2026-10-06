<?php
session_start();
include 'koneksi.php';
include 'ceklogin.php';
$npm = $_SESSION['id_surat'];

// Ambil semua surat masuk
$sql = "SELECT * FROM surat WHERE status_surat = 'surat masuk' ORDER BY id_surat ASC";
$q   = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Manajemen Arsip Administrasi Surat - Surat Masuk</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        background: url("gambar/bgbiru2.png") no-repeat center center fixed;
        background-size: cover;
        padding: 40px; /* Agar background terlihat di semua sisi */
        font-family: "Poppins", sans-serif;
        margin-top:40px;
    }

    /* Bingkai semi transparan */
    .content-box {
        background: rgba(255, 255, 255, 0.75);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }


.btn-add {
  display: inline-block;   /* ukuran mengikuti isi */
  padding: 6px 14px;  
  background-color: #3D8C87;
  border: none;
  color: #ECE4BF;
  font-weight: 500;
  border-radius: 10px;
  transition: all 0.3s ease;
  margin-right: 30px;
  width: 150px;
  margin-bottom: 10px;
}

.btn-add:hover {
  background-color: #ECE4BF;
  color: #3D8C87;
  transform: scale(1.05);
  
}


</style>
</head>

<body>

<div class="container content-box mt-4">

    <h3 class="text-center mb-4">📋 Data Surat Masuk</h3>
    <div class="text-end">
        <a href="inputsurat.php">
            <button class="btn-add">Add</button>
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>No Surat</th>
                <th>Tanggal Diterima</th>
                <th>Asal Surat</th>
                <th>Perihal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($data = mysqli_fetch_assoc($q)) : ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $data['no_surat']; ?></td>
                <td><?= $data['tgl_diterima']; ?></td>
                <td><?= $data['asal_surat']; ?></td>
                <td><?= $data['perihal']; ?></td>
               
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>
