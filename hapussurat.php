<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

echo "<b>FILE DIEKSEKUSI</b><br>";

if (!isset($_GET['id_surat'])) {
    die("ID surat TIDAK ADA");
}

$id_surat = $_GET['id_surat'];
echo "ID SURAT: $id_surat<br>";

$q = mysqli_query($koneksi, "SELECT file_surat FROM surat WHERE id_surat='$id_surat'");
if (!$q) {
    die("QUERY GAGAL: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($q);
var_dump($data);

if (!$data) {
    die("DATA TIDAK DITEMUKAN DI DATABASE");
}

$file = $data['file_surat'];
$path = "uploads/" . $file;

echo "<br>PATH FILE: $path<br>";

if (file_exists($path)) {
    echo "FILE ADA<br>";
    unlink($path);
    echo "FILE DIHAPUS<br>";
} else {
    echo "FILE TIDAK DITEMUKAN<br>";
}

mysqli_query($koneksi, "DELETE FROM surat WHERE id_surat='$id_surat'");
echo "DATABASE DIHAPUS<br>";

/* ====== TIMER 3 DETIK ====== */
echo "
<script>
    setTimeout(function() {
        window.location.href = 'semuasurat.php';
    }, 3000);
</script>
";

exit;