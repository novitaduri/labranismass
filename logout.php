<?php
session_start();

// Hapus semua variabel session
$_SESSION = [];

// Hapus session
session_unset();
session_destroy();

// Redirect ke home
header("Location: index.php");
exit();
?>
