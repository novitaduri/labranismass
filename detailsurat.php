<?php
session_start();
include 'koneksi.php';
include 'ceklogin.php';
/* =====================================================
   MODE SIMPAN (POST) → UPDATE DATA
===================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['id_surat'])) {
        die("ID surat tidak valid.");
    }

    $id_surat = mysqli_real_escape_string($koneksi, $_POST['id_surat']);

    // ambil file lama
    $q_old = mysqli_query($koneksi, "SELECT file_surat FROM surat WHERE id_surat='$id_surat' LIMIT 1");
    $d_old = mysqli_fetch_assoc($q_old);
    if (!$d_old) {
        die("Data surat tidak ditemukan.");
    }
    $file_lama = $d_old['file_surat'];

    // data input
    $no_agenda       = $_POST['no_agenda'];
    $no_surat        = $_POST['no_surat'];
    $tgl_surat       = $_POST['tgl_surat'];
    $tgl_diterima    = $_POST['tgl_diterima'];
    $asal_surat      = $_POST['asal_surat'];
    $perihal         = $_POST['perihal'];
    $jumlah_lampiran = $_POST['jumlah_lampiran'];
    $status_surat    = $_POST['status_surat'];

    /* ===== FILE UPLOAD ===== */
    $file_surat = $file_lama;

    if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] === 0) {

        $folder = "file_surat/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $nama_file = time() . "_" . basename($_FILES['file_surat']['name']);
        $target    = $folder . $nama_file;

        if (move_uploaded_file($_FILES['file_surat']['tmp_name'], $target)) {

            if (!empty($file_lama) && file_exists($folder . $file_lama)) {
                unlink($folder . $file_lama);
            }

            $file_surat = $nama_file;
        }
    }

    /* ===== UPDATE (BUKAN INSERT) ===== */
    $sql = "
    UPDATE surat SET
        no_agenda        = '$no_agenda',
        no_surat         = '$no_surat',
        tgl_surat        = '$tgl_surat',
        tgl_diterima     = '$tgl_diterima',
        asal_surat       = '$asal_surat',
        perihal          = '$perihal',
        jumlah_lampiran  = '$jumlah_lampiran',
        file_surat       = '$file_surat',
        status_surat     = '$status_surat'
    WHERE id_surat = '$id_surat'
    ";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: semuasurat.php?status=updated");
        exit;
    } else {
        die("Gagal menyimpan perubahan: " . mysqli_error($koneksi));
    }
}

/* =====================================================
   MODE TAMPIL (GET)
===================================================== */
if (!isset($_GET['id_surat']) || empty($_GET['id_surat'])) {
    die("ID surat belum ditentukan.");
}

$id_surat = mysqli_real_escape_string($koneksi, $_GET['id_surat']);

$q = mysqli_query($koneksi, "
SELECT *
FROM surat
WHERE id_surat = '$id_surat'
LIMIT 1
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data surat tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Surat</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
*{box-sizing:border-box}
body{
    background:url("gambar/bgbiru2.png") no-repeat center center fixed;
    background-size:cover;
    font-family:Poppins,sans-serif;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}
.container{
    background:rgba(255,255,255,.85);
    padding:40px 50px;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,.2);
    width:50%;
    max-width:500px;
}
.data-label{font-weight:600;margin-bottom:6px}
.data-item input,.data-item select{
    border-radius:12px;
    border:1px solid #0099cc;
    padding:10px;
    margin-bottom:12px;
}
.btn-detail{
    padding:10px 35px;
    border-radius:25px;
    background:linear-gradient(45deg,#0099cc,#00c6ff);
    color:#fff;
    border:none;
    font-weight:600;
}
.btn-detail:hover{background:linear-gradient(45deg,#0078a6,#00a3d8)}
.d-none{display:none}
.button-wrapper{display:flex;justify-content:center;gap:10px}
</style>
</head>

<body>

<div class="container">

<h2 class="text-center mb-4">
📋 Data Surat – <?= htmlspecialchars($data['no_surat']) ?>
</h2>

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="id_surat" value="<?= $data['id_surat'] ?>">

<?php
$fields = [
    'no_agenda'=>'No Agenda',
    'no_surat'=>'No Surat',
    'tgl_surat'=>'Tanggal Surat',
    'tgl_diterima'=>'Tanggal Diterima',
    'asal_surat'=>'Asal Surat',
    'perihal'=>'Perihal',
    'jumlah_lampiran'=>'Jumlah Lampiran',
    'file_surat'=>'File Surat',
    'status_surat'=>'Status Surat'
];
foreach($fields as $name=>$label):
?>
<div class="data-item" id="<?= $name ?>-wrapper">
<label class="data-label"><?= $label ?></label>
<?php if($name==='file_surat'): ?>
<input class="form-control editable" value="<?= htmlspecialchars($data[$name]) ?>" readonly>
<?php else: ?>
<input name="<?= $name ?>" class="form-control editable"
       value="<?= htmlspecialchars($data[$name]) ?>" readonly>
<?php endif; ?>
</div>
<?php endforeach; ?>

<div class="button-wrapper mt-3">
<button type="button" class="btn-detail" onclick="enableEdit()">Edit</button>
<button type="submit" class="btn-detail d-none" id="btnSimpan">Simpan</button>
</div>

<div class="text-center mt-3">
<a href="semuasurat.php" class="btn-detail"
onclick="return confirm('Perubahan belum disimpan. Yakin ingin keluar?')">Close</a>
</div>

</form>
</div>

<script>
function enableEdit(){
document.querySelectorAll('.editable').forEach(e=>e.removeAttribute('readonly'));
document.getElementById('btnSimpan').classList.remove('d-none');

['tgl_surat','tgl_diterima'].forEach(id=>{
const w=document.getElementById(id+'-wrapper');
const v=w.querySelector('input').value;
w.innerHTML=`<label class="data-label">${w.querySelector('label').innerText}</label>
<input type="date" name="${id}" class="form-control editable" value="${v}">`;
});

const s=document.getElementById('status_surat-wrapper');
const c=s.querySelector('input').value;
s.innerHTML=`<label class="data-label">Status Surat</label>
<select name="status_surat" class="form-select editable">
<option value="surat masuk" ${c==='surat masuk'?'selected':''}>Surat Masuk</option>
<option value="surat keluar" ${c==='surat keluar'?'selected':''}>Surat Keluar</option>
</select>`;

const f=document.getElementById('file_surat-wrapper');
const o=f.querySelector('input').value;
f.innerHTML=`<label class="data-label">File Surat</label>
<input type="file" name="file_surat" class="form-control editable">
<small>File saat ini: ${o}</small>`;
}
</script>

</body>
</html>