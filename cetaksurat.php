<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id_surat']) || empty($_GET['id_surat'])) {
    die("ID surat tidak valid.");
}

$id_surat = mysqli_real_escape_string($koneksi, $_GET['id_surat']);

$q = mysqli_query($koneksi, "
    SELECT file_surat 
    FROM surat 
    WHERE id_surat = '$id_surat'
    LIMIT 1
");

$data = mysqli_fetch_assoc($q);

if (!$data || empty($data['file_surat'])) {
    die("File surat tidak ditemukan.");
}

$file = trim($data['file_surat']);
$path = __DIR__ . "/uploads/" . $file;

if (!file_exists($path)) {
    die("File tidak ada di server.");
}

/* ================= DETEKSI MIME TYPE ================= */
$mime = mime_content_type($path);

/* ================= TAMPILKAN FILE ================= */
header("Content-Type: $mime");
header("Content-Disposition: inline; filename=\"" . basename($file) . "\"");
header("Content-Length: " . filesize($path));

readfile($path);
exit;