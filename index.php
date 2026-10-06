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

if (isset($alert)) {
  $alert = strip_tags($alert, '<div><span><strong><button><br>');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SMAAS - Login Sistem</title>

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
  padding: 20px;
}

/* LOGIN BOX */
.login-container {
  background: rgba(255, 255, 255, 0.70);
  padding: 40px 50px;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  width: 100%;
  max-width: 420px;
  animation: fadeIn 1s ease;
}

.login-container img {
  border-radius: 50%;
  width: 120px;
  height: 120px;
  object-fit: cover;
  margin-bottom: 10px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.login-container h2 {
  font-weight: 700;
  color: #000000;
  white-space: nowrap;
}

/* BUTTON */
.btn-login,
.btn-daftar {
  background-color: #3D8C87;
  border: none;
  color: #ECE4BF;
  font-weight: 500;
  border-radius: 10px;
  width: 100%;
  padding: 10px;
  transition: all 0.3s ease;
}

.btn-login:hover,
.btn-daftar:hover {
  background-color: #ECE4BF;
  color: #3D8C87;
  transform: scale(1.05);
}

label {
  font-weight: 500;
  color: #000000;
}

/* =====================
   RESPONSIVE HP
   ===================== */
@media (max-width: 576px) {

  body {
    padding: 10px;
  }

  .login-container {
    padding: 25px;
    border-radius: 16px;
  }

  .login-container img {
    width: 100px;
    height: 100px;
  }

  .login-container h2 {
    font-size: 22px;
  }

  .login-container p {
    font-size: 14px;
  }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
</head>

<body>

<div class="login-container text-center">

  <!-- ALERT -->
  <?php if (isset($alert) && $alert != "") echo $alert; ?>

  <img src="gambar/logo.png" alt="Logo">
  <h2>Login Sistem</h2>
  <p class="text-muted mb-4">Silakan masuk untuk melanjutkan</p>

  <form method="post" action="proseslogin.php">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

    <div class="mb-3 text-start">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username Anda" required autocomplete="off">
    </div>

    <div class="mb-4 text-start">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
    </div>
    
    <button type="submit" class="btn-login">Masuk</button>
    <p>
      Belum punya akun? 
      <a href="daftar.php" class="text-primary">Daftar</a>
    </p>
  </form>

</div>

</body>
</html>