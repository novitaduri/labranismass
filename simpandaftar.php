<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Wisuda - Simpan Data Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_POST['username'], $_POST['password'])) {
            // Ambil data dari form dan amankan
            $nama = htmlspecialchars($_POST['nama']);
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
           

            // Koneksi database
            include_once('koneksi.php');

            // Query simpan data
            $sql = "INSERT INTO `users`(`id_user`, `nama`, `username`, `password`, `created_at`)
                    VALUES ('$id_user', '$nama',  '$username', '$password', '$created_at')";
            $q = mysqli_query($koneksi, $sql);

            if ($q) {
                echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> Data Mahasiswa telah disimpan ke database.
        <script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 3000);
        </script>
    </div>';
} else {
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> Data gagal disimpan: ' . mysqli_error($koneksi) . '
        <script>
            setTimeout(function() {
                window.history.back();
            }, 3000);
        </script>
    </div>';
}
} else {
    echo '
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>⚠️ Form belum lengkap!</strong> Silakan isi semua data terlebih dahulu.
        <script>
            setTimeout(function() {
                window.history.back();
            }, 3000);
        </script>
    </div>';
}
        ?>
    </div>
</body>
</html>
