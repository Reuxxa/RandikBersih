<?php
// Memulai sesi
session_start();

// Menghapus semua data sesi
session_unset();

// Menghancurkan sesi
session_destroy();

// Pengalihan ke halaman login setelah logout
header("Location: homepage.php");
exit();
?>
