<?php
session_start();
include 'koneksi.php';
include 'ceklogin.php';
mysqli_set_charset($koneksi, "utf8mb4");

/* TOTAL SEMUA SURAT */
$total_surat = 0;
$q1 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_surat FROM surat");
if ($q1) {
    $data1 = mysqli_fetch_assoc($q1);
    $total_surat = $data1['total_surat'] ?? 0;
}

/* TOTAL SURAT MASUK */
$total_suratmasuk = 0;
$q2 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_suratmasuk FROM surat WHERE status_surat = 'surat masuk'");
if ($q2) {
    $data2 = mysqli_fetch_assoc($q2);
    $total_suratmasuk = $data2['total_suratmasuk'] ?? 0;
}

/* TOTAL SURAT KELUAR */
$total_suratkeluar = 0;
$q3 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_suratkeluar FROM surat WHERE status_surat = 'surat keluar'");
if ($q3) {
    $data3 = mysqli_fetch_assoc($q3);
    $total_suratkeluar = $data3['total_suratkeluar'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* =====================
   GLOBAL
   ===================== */
* {
    box-sizing: border-box;
}

body {
    background: url("gambar/bgbiru2.jpg") no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
    font-family: "Times New Roman", serif;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

/* CARD UTAMA */
.dashboard-card {
    background: rgba(255, 255, 255, 0.78);
    border-radius: 28px;
    padding: 50px;
    box-shadow: 0 18px 45px rgba(0,0,0,0.35);
    width: 100%;
    max-width: 1200px;
}

/* HEADER */
.header-admin {
    font-size: 32px;
    font-weight: bold;
    color: #1E3A5F;
    margin-bottom: 30px;
}

/* CARD STATISTIK */
.my-card {
    background: linear-gradient(135deg, #2B6CB0, #1E3A5F);
    border-radius: 22px;
    color: #F7FAFC;
    height: 230px;
    padding: 25px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-shadow: 0 12px 30px rgba(30, 58, 95, 0.35);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.my-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(30, 58, 95, 0.45);
}

.my-card h5 {
    font-weight: 600;
    font-size: 18px;
    margin-bottom: 10px;
}

.my-card h2 {
    font-size: 40px;
    font-weight: bold;
    margin: 0;
}

.my-card p {
    font-size: 15px;
    margin-top: 10px;
}

/* =====================
   RESPONSIVE HP
   ===================== */
@media (max-width: 768px) {

    body {
        padding: 15px;
        align-items: flex-start;
    }

    .dashboard-card {
        padding: 25px;
        border-radius: 20px;
    }

    .header-admin {
        font-size: 24px;
        text-align: center;
    }

    .my-card {
        height: auto;
        padding: 20px;
        text-align: center;
    }

    .my-card h2 {
        font-size: 32px;
    }

    .my-card p {
        font-size: 14px;
    }
}
</style>
</head>

<body>

<div class="dashboard-card">

    <div class="header-admin">
        Selamat Datang
    </div>

    <div class="row g-4">

        <div class="col-md-4 col-12">
            <div class="my-card">
                <h5>📬 Total Surat</h5>
                <h2><?= $total_surat; ?></h2>
                <p>Jumlah Semua Surat</p>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="my-card">
                <h5>📩 Total Surat Masuk</h5>
                <h2><?= $total_suratmasuk; ?></h2>
                <p>Jumlah Surat Masuk</p>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="my-card">
                <h5>📤 Total Surat Keluar</h5>
                <h2><?= $total_suratkeluar; ?></h2>
                <p>Jumlah Surat Keluar</p>
            </div>
        </div>

    </div>

</div>

</body>
</html>