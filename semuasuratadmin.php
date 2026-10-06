<?php
session_start();
include 'koneksi.php';
include 'ceklogin.php';
$sql = "SELECT * FROM surat ORDER BY id_surat ASC";
$q   = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sistem Manajemen Arsip Administrasi Surat - Rekapan Surat</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
body{
    background:url("gambar/bgbiru2.png") no-repeat center center fixed;
    background-size:cover;
    padding:40px;
    font-family:"Poppins",sans-serif;
    margin-top:40px;
}
.content-box{
    background:rgba(255,255,255,.75);
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,.2);
}
.btn-edit{
    background:linear-gradient(to right,#1e3c72,#2a5298);
    border:none;
    color:#fff;
    font-weight:500;
    border-radius:10px;
    width:130px;
    padding:8px;
    transition:.3s;
    text-decoration: none;
    display:inline-block;
}
.btn-edit:hover{
    transform:scale(1.05);
}
.btn-download{
    background:linear-gradient(to right,#11998e,#38ef7d);
    border:none;
    color:#fff;
    font-weight:500;
    border-radius:10px;
    width:130px;
    padding:8px;
    transition:.3s;
    text-decoration:none;
    display:inline-block;
}
.btn-download:hover{
    transform:scale(1.05);
}
</style>
</head>

<body>

<div class="container content-box mt-4">

<h3 class="text-center mb-4">📋 Data Semua Surat</h3>

<table class="table table-bordered table-striped">
<thead>
<tr class="text-center">
    <th>No</th>
    <th>No Surat</th>
    <th>Tanggal Diterima</th>
    <th>Asal Surat</th>
    <th>Perihal</th>
    <th>Lihat</th>
    <th>Download</th>
    <th>Hapus</th>
</tr>
</thead>

<tbody>
<?php 
$no = 1;
while($data = mysqli_fetch_assoc($q)) :
?>
<tr>
    <td class="text-center"><?= $no++; ?></td>
    <td><?= htmlspecialchars($data['no_surat']); ?></td>
    <td><?= htmlspecialchars($data['tgl_diterima']); ?></td>
    <td><?= htmlspecialchars($data['asal_surat']); ?></td>
    <td><?= htmlspecialchars($data['perihal']); ?></td>

    <!-- BUTTON LIHAT -->
    <td class="text-center">
        <a href="detailsurat.php?id_surat=<?= $data['id_surat']; ?>" class="btn-edit">
            Lihat
        </a>
    </td>

    <!-- BUTTON DOWNLOAD -->
    <td class="text-center">
    <?php if (!empty($data['file_surat'])): ?>
        <a href="cetaksurat.php?id_surat=<?= $data['id_surat']; ?>" 
           class="btn-download">
           Download
        </a>
    <?php else: ?>
        <span class="text-muted">Tidak ada file</span>
    <?php endif; ?>
    </td>

    <!-- BUTTON HAPUS -->
    <td class="text-center">
    <?php if (!empty($data['file_surat'])): ?>
        <a href="hapussurat.php?id_surat=<?= $data['id_surat']; ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin ingin menghapus surat dan file ini?');">
           Hapus
        </a>
    <?php else: ?>
        <span class="text-muted">-</span>
    <?php endif; ?>
    </td>

</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>

</body>
</html>