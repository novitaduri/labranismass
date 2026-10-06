<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Wisuda - Pendaftaran Peserta</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: "Poppins", sans-serif;
  margin: 0;
  padding: 20px;
}

/* =====================
   CARD CONTAINER
   ===================== */
.card {
  background: rgba(255, 255, 255, 0.70);
  padding: 40px 50px;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  width: 100%;
  max-width: 420px;
  animation: fadeIn 1s ease;
}

/* =====================
   HEADER / LOGO
   ===================== */
.header-title img {
  border-radius: 50%;
  width: 120px;
  height: 120px;
  object-fit: cover;
  margin-bottom: 10px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.header-title h2 {
  font-weight: 700;
  color: #000000;
  font-size: 1.25rem;
  margin-top: 10px;
  margin-bottom: 20px;
  text-align: center;
}

/* =====================
   FORM
   ===================== */
label {
  font-weight: 500;
  color: #000000;
}

.form-section {
  margin-bottom: 15px;
}

.form-control {
  border-radius: 10px;
  padding: 10px;
  font-size: 15px;
  border: 1px solid #ced4da;
}

.form-control:focus {
  border-color: #3D8C87;
  box-shadow: 0 0 0 0.15rem rgba(61, 140, 135, 0.3);
}

/* =====================
   BUTTON
   ===================== */
button {
  background-color: #3D8C87;
  border: none;
  color: #ECE4BF;
  font-weight: 500;
  border-radius: 10px;
  width: 100%;
  padding: 10px;
  transition: all 0.3s ease;
}

button:hover {
  background-color: #ECE4BF;
  color: #3D8C87;
  transform: scale(1.05);
}

/* =====================
   FOOTER
   ===================== */
.footer-text {
  text-align: center;
  margin-top: 20px;
  font-size: 14px;
  color: #555;
}

/* =====================
   RESPONSIVE HP
   ===================== */
@media (max-width: 576px) {

  body {
    align-items: flex-start;
    padding: 15px;
  }

  .card {
    padding: 25px;
    border-radius: 16px;
  }

  .header-title img {
    width: 90px;
    height: 90px;
  }

  .header-title h2 {
    font-size: 1.1rem;
  }

  .footer-text {
    font-size: 12px;
  }
}

/* =====================
   ANIMASI
   ===================== */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
</head>

<body>

<div class="card">
  <div class="header-title">
    <div class="d-flex justify-content-center">
      <img src="gambar/logo.png" alt="Logo">
    </div>
    <h2>Pendaftaran Akun<br>Sistem Manajemen Arsip Surat</h2>
  </div>

<form method="post" action="simpandaftar.php">

  <div class="form-section">
    <label for="nama">Nama Lengkap</label>
    <input type="text" name="nama" id="nama" class="form-control" required>
  </div>

  <div class="form-section">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" class="form-control" required>
  </div>

  <div class="form-section">
    <label for="password">Kata Sandi</label>
    <input type="password" name="password" id="password" class="form-control" required>
  </div>
   
  <button type="submit" name="submit">Daftar</button>

  <div class="footer-text">
    © 2026 Sistem Manajemen Arsip Surat | Data Akun SMAAS SDN 51 Kota Bengkulu
  </div>

</form>
</div>

</body>
</html>