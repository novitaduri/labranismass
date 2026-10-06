<?php
// ======================
// CEK LOGIN TERPUSAT
// ======================
session_start();

// Cegah cache supaya user tidak bisa kembali pakai tombol back
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Jika session admin atau id_user tidak ada, redirect ke login
if (
    (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) &&
    (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true)
) {
    // Bisa juga tambah alert GET supaya muncul pesan di index.php
    header("Location: index.php?alert=login");
    exit;
}
?>