<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    die("Akses ditolak. Anda harus login terlebih dahulu.");
}

$id_user = $_SESSION['id_user'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    include_once('koneksi.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $id_surat        = $_POST['id_surat'] ?? '';
    $no_agenda       = $_POST['no_agenda'] ?? '';
    $no_surat        = $_POST['no_surat'] ?? '';
    $tgl_surat       = $_POST['tgl_surat'] ?? '';
    $tgl_diterima    = $_POST['tgl_diterima'] ?? '';
    $asal_surat      = $_POST['asal_surat'] ?? '';
    $perihal         = $_POST['perihal'] ?? '';
    $jumlah_lampiran = $_POST['jumlah_lampiran'] ?? '';
    $status_surat    = $_POST['status_surat'] ?? '';
    $file_surat      = ''; // default kosong
    

    // ====== HANDLE UPLOAD FILE ======
    if (!empty($_FILES['file_surat']['name'])) {

        $uploadDir = 'uploads/';

        // pastikan folder ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // ===== TAMBAHAN 1: CEK ERROR UPLOAD =====
        if ($_FILES['file_surat']['error'] !== UPLOAD_ERR_OK) {
            die("Upload error code: " . $_FILES['file_surat']['error']);
        }

        $tmpName  = $_FILES['file_surat']['tmp_name'];
        $ext      = pathinfo($_FILES['file_surat']['name'], PATHINFO_EXTENSION);

        // ===== TAMBAHAN 2: VALIDASI EXTENSION =====
        $allowed = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg'];
        if (!in_array(strtolower($ext), $allowed)) {
            die("Format file tidak diizinkan.");
        }

        $fileName = time() . '_surat.' . $ext;

        // ===== TAMBAHAN 3: PASTIKAN FILE VALID =====
        if (!is_uploaded_file($tmpName)) {
            die("File upload tidak valid.");
        }

        if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
            $file_surat = $fileName;
        } else {
            die("Gagal upload file ke folder uploads.");
        }
    }

    $sql = "INSERT INTO surat
        (no_agenda, no_surat, tgl_surat, tgl_diterima, asal_surat, perihal, jumlah_lampiran, file_surat, status_surat, id_user)
        VALUES
        ('$no_agenda', '$no_surat', '$tgl_surat', '$tgl_diterima', '$asal_surat', '$perihal', '$jumlah_lampiran', '$file_surat', '$status_surat', '$id_user')";

    $q = mysqli_query($koneksi, $sql);

    if ($q) {
        echo '
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil!</strong> Data Surat telah disimpan ke database.
</div>';

        echo "
<script>
    setTimeout(function() {
        window.location.href = document.referrer;
    }, 2000);
</script>
";
    } else {
        echo '
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> ' . mysqli_error($koneksi) . '
</div>';
    }
}
?>