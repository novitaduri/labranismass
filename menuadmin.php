<?php
include 'ceklogin.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Manajemen Arsip Administrasi Surat</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    html, body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Banner atas */
 
    .top-banner h1 {
      color: white;
      font-size: 30px;
      text-shadow: 2px 2px 7px black;
    }

    /* Logo navbar */
    .navbar-brand img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
    }

    /* Latar konten */
    .content-bg {
      background: url('gambar/bgbiru2.jpg') no-repeat center center;
      no-repeat center center fixed;
      background-size: cover;
      padding: 10px;
      padding-top: 10px; /* beri jarak supaya tidak tertutup navbar */
    }

    /* FRAME GLOSSY TRANSPARAN */
    .frame-wrapper {
      backdrop-filter: blur(15px) saturate(180%);
      -webkit-backdrop-filter: blur(15px) saturate(180%);
      background: rgba(255, 255, 255, 0.25);
      border-radius: 18px;
      padding: 10px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    }

    iframe {
      width: 100%;
      border: none;
      border-radius: 15px;
      background: transparent;
      overflow: hidden !important;
      min-height: 500px;
    }

    /* Tambahan untuk fixed navbar */
    body {
      padding-top: 0px; /* memberi ruang agar konten tidak tertutup */
    }
  </style>

  <!-- AUTO RESIZE IFRAME -->
  <script>
    function autoResize() {
      const iframe = document.getElementsByName('framemenu')[0];
      if (!iframe) return;
      try {
        const doc = iframe.contentWindow.document;
        iframe.style.height = doc.body.scrollHeight + "px";
      } catch (e) {}
    }
    setInterval(autoResize, 300);
  </script>

</head>
<body>

<!-- Banner -->
<!-- Banner -->
<div class="top-banner">
  <div class="overlay">
    <h1>SMAAS</h1>
    <p>Sistem Manajemen Arsip Administrasi Surat</p>
  </div>
</div>

<style>
/* Banner Simpel & Modern */
/* ================================
   NAVBAR CUSTOM
   ================================ */
.custom-navbar {
  background-color:#0B1F33 !important;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.custom-navbar .nav-link,
.custom-navbar .navbar-brand,
.custom-navbar .navbar-text {
  color: #ECE4BF !important;
  font-weight: 500;
    
}

.custom-navbar .nav-link.active {
  font-weight: 700;
  text-decoration: none;
}

.custom-navbar .nav-link:hover {
  color: #ffffff !important;
}

/* Search di Navbar */
.custom-navbar .form-control {
  background-color: #ECE4BF;
  color: #000000;
  border: none;
}

.custom-navbar .btn-outline-light {
  color: #ECE4BF;
  border-color: #ECE4BF;
}

.custom-navbar .btn-outline-light:hover {
  background-color: #ECE4BF;
  color: #3D8C87;
}

/* ================================
   TOP BANNER SISTEM WISUDA
   ================================ */
.top-banner {
  position: relative;
  width: 100%;
  height: 100px;
  background:  url('gambar/togaa.jpg') no-repeat center center;
  background-size: cover;
  background-position: center 57%;
  display: flex;
  align-items: center;
  justify-content: center;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
}

/* Overlay teks banner */
.overlay {
  text-align: center;
}

.overlay h1 {
  color: #000000;                 /* hitam */
  font-family: "Times New Roman", Times, serif;
  font-weight: 700;               /* bold */
  white-space: nowrap;
}
  /* Pinggiran krem */
  .text-shadow:{
    -1px -1px 0 #ECE4BF,
     1px -1px 0 #ECE4BF,
    -1px  1px 0 #ECE4BF,
     1px  1px 0 #ECE4BF;
}

.overlay p {
  color: #333333;
  margin: 0;
}


/* Animasi FadeInUp */
@keyframes fadeInUp {
  0% {opacity:0; transform: translateY(20px);}
  100% {opacity:1; transform: translateY(0);}
}

@media (max-width: 768px) {
  .overlay h1 { font-size: 2rem; }
  .overlay p { font-size: 0.95rem; }
}
</style>

  <!-- Navbar Fixed -->
  <nav class="navbar navbar-expand-sm custom-navbar">
    <div class="container-fluid">


      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link active" href="home.php" target="framemenu">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="suratmasuk.php" target="framemenu">Surat Masuk</a></li>
          <li class="nav-item"><a class="nav-link" href="suratkeluar.php" target="framemenu">Surat Keluar</a></li>
          <li class="nav-item"><a class="nav-link" href="semuasuratadmin.php" target="framemenu">Semua Surat</a></li>
        </ul>

        <form class="d-flex me-2" role="search">
          <input class="form-control me-2" type="search" placeholder="Search">
          <button class="btn btn-outline-light" type="submit">Search</button>
        </form>

        <a href="index.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </nav>

  <!-- GLOSSY FRAME UNTUK KONTEN -->
  <div class="content-bg">
    <div class="frame-wrapper">
      <iframe name="framemenu" src="home.php"></iframe>
    </div>
  </div>

</body>
</html>
