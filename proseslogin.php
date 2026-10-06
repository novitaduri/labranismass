<?php 
session_start();
ob_start();
include_once('koneksi.php');

/* ================= SECURITY HEADERS ================= */
header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("Content-Security-Policy: default-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'; object-src 'none'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net;");

/* ================= HELPERS ================= */
function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* ================= AES CONFIG ================= */
if (!defined('APP_AES_KEY_B64')) {
    define('APP_AES_KEY_B64', 'pl28I5dD1ev5obsBDUCJ9i3ElJX4JIW8n+Znagc8Eek=');
}

function app_aes_key() {
    $b64 = getenv('APP_AES_KEY_B64') ?: APP_AES_KEY_B64;
    $key = base64_decode($b64, true);
    if ($key === false || strlen($key) !== 32) {
        die('Konfigurasi keamanan (AES key) belum benar.');
    }
    return $key;
}

function encrypt_bcrypt_hash($bcryptHash) {
    $key = app_aes_key();
    $iv  = random_bytes(16);
    $ct  = openssl_encrypt($bcryptHash, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    $mac = hash_hmac('sha256', $iv . $ct, $key, true);
    return 'enc:' . base64_encode($iv . $ct . $mac);
}

function decrypt_to_bcrypt_hash($enc) {
    if (strpos($enc, 'enc:') !== 0) return null;
    $raw = base64_decode(substr($enc, 4), true);
    $iv  = substr($raw, 0, 16);
    $mac = substr($raw, -32);
    $ct  = substr($raw, 16, -32);
    $key = app_aes_key();
    if (!hash_equals($mac, hash_hmac('sha256', $iv . $ct, $key, true))) return null;
    return openssl_decrypt($ct, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

function is_bcrypt_hash($s) {
    return !empty(password_get_info((string)$s)['algo']);
}

/* ================= LOGIN ================= */
if (isset($_POST['username'], $_POST['password'])) {

    if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {

        echo '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Gagal!</strong> Permintaan tidak valid (CSRF).
                <button type="button" class="btn-close" onclick="window.history.back()"></button>
              </div>';
        echo "<script>setTimeout(function(){ window.location.href='index.php'; }, 3000);</script>";
        exit;
    }

    $_SESSION['csrf_token'] = base64_encode(random_bytes(32));

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    /* ===== ADMIN ===== */
    if ($username === "admin" && $password === "admin123") {

        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        $_SESSION['nama']  = "Admin";

        echo '<div class="alert alert-success alert-dismissible fade show">
                <strong>Prodi Login!</strong> Selamat datang Admin.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
        echo "<script>setTimeout(function(){ window.location.href='menuadmin.php'; }, 3000);</script>";
        exit;
    }

    /* ===== USER SECURE ===== */
    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $q   = mysqli_query($koneksi, $sql);

    if ($q && mysqli_num_rows($q) > 0) {

        $data = mysqli_fetch_assoc($q);
        $stored = $data['password'];
        $ok = false;

        if (strpos($stored, 'enc:') === 0) {
            $bcrypt = decrypt_to_bcrypt_hash($stored);
            if ($bcrypt && password_verify($password, $bcrypt)) $ok = true;
        } elseif (is_bcrypt_hash($stored) && password_verify($password, $stored)) {
            $ok = true;
        } elseif (hash_equals($stored, $password)) {
            $ok = true;
            $new = encrypt_bcrypt_hash(password_hash($password, PASSWORD_BCRYPT));
            mysqli_query($koneksi, "UPDATE users SET password='$new' WHERE username='$username'");
        }

        if ($ok) {
            session_regenerate_id(true);
            $_SESSION['id_user']  = $data['id_user'];
            $_SESSION['username'] = $data['username'];

            echo '<div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> Selamat datang ' . e($data['username']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
            echo "<script>setTimeout(function(){ window.location.href='menuuser.php'; }, 3000);</script>";
            exit;
        }
    }

    echo '<div class="alert alert-danger alert-dismissible fade show">
            <strong>Gagal!</strong> Username atau password salah.
            <button type="button" class="btn-close" onclick="window.history.back()"></button>
          </div>';
    echo "<script>setTimeout(function(){ window.location.href='index.php'; }, 3000);</script>";
}
?>