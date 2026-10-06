<?php 
include 'ceklogin.php';
<?php 
// ===============================
// [SECURITY ADDON] SESSION + CSRF
// ===============================
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
  ]);
  ini_set('session.use_strict_mode', '1');
  ini_set('session.cookie_httponly', '1');
  if ($isHttps) { ini_set('session.cookie_secure', '1'); }
  session_start();
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = base64_encode(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("Content-Security-Policy: default-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'; object-src 'none'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; script-src 'self' https://cdn.jsdelivr.net;");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Form Surat Masuk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* =====================
   GLOBAL
   ===================== */
* { box-sizing: border-box; }

body {
  background: url("gambar/bgbiru2.png") no-repeat center center fixed;
  background-size: cover;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: "Poppins", sans-serif;
  padding: 20px;
}

.card-container {
  background: rgba(255,255,255,0.85);
  padding: 40px 50px;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
  width: 50%;
  max-width: 500px;
  animation: fadeIn 1s ease;
}

.card-container h2 {
  font-weight: 700;
  color: #000;
  margin-bottom: 20px;
  text-align: center;
}

.card-container img {
  display: block;
  margin: 0 auto 15px auto;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.form-control, .form-select, input[type="file"], textarea {
  border-radius: 12px;
  padding: 10px 14px;
  border: 1px solid #0099cc;
}

label {
  font-weight: 600;
  color: #000;
  display: block;
  margin-bottom: 6px;
}
.btn-group {
  display: flex;               /* tombol berdampingan */
  justify-content: center;     /* posisi group di tengah card */
  gap: 0px;                   /* jarak antar tombol */
  margin-top: 20px;
}
.btn-action {
  display: block;              /* full block supaya margin auto bekerja */
  margin: 10px auto 20px auto;
  padding: 12px 40px;
  border-radius: 25px;
  background: linear-gradient(45deg, #0099cc, #00c6ff);
  color: #fff;
  font-weight: 600;
  font-size: 16px;             /* pastikan sama */
  border: none;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: all 0.3s ease;
}

.btn-action:hover {
  background: linear-gradient(45deg, #0078a6, #00a3d8);
  transform: scale(1.03);
}

.footer-text {
  text-align: center;
  font-size: 14px;
  color: #000;
  margin-top: 15px;
}

/* RESPONSIVE */
@media (max-width: 576px) {
  .card-container { padding: 25px; }
  .card-container img { width: 60px; height: 60px; }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px);}
  to { opacity: 1; transform: translateY(0);}
}
</style>
</head>

<body>

<div class="card-container">

  <img src="gambar/logo.png" alt="Logo">
  <h2>Form Surat Masuk</h2>

  <form method="post" action="simpansurat.php" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

    <div class="mb-3">
      <label>No. Agenda</label>
      <input type="text" name="no_agenda" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>No. Surat</label>
      <input type="text" name="no_surat" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Tanggal Surat</label>
      <input type="date" name="tgl_surat" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Tanggal Diterima</label>
      <input type="date" name="tgl_diterima" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Asal Surat</label>
      <input type="text" name="asal_surat" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Perihal</label>
      <textarea name="perihal" class="form-control" rows="3" required></textarea>
    </div>

    <div class="mb-3">
      <label>Jumlah Lampiran</label>
      <input type="number" name="jumlah_lampiran" class="form-control" min="0" required>
    </div>

    <div class="mb-3">
      <label>File Surat</label>
      <input type="file" name="file_surat" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Status Surat</label>
      <select name="status_surat" class="form-select" required>
        <option value="" disabled selected>Pilih Status Surat</option>
        <option value="surat masuk">Surat Masuk</option>
        <option value="surat keluar">Surat Keluar</option>
      </select>
    </div>

    <div class="btn-group">
      <button type="submit" class="btn-action">Simpan</button>
      
    </div>
    <div class="footer-text">© 2026 Sistem Manajemen Arsip Administrasi Surat • SDN 51 Kota Bengkulu</div>

  </form>

</div>

</body>
</html>