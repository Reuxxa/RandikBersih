<?php
include('db.php');

// Query untuk menghitung jumlah laporan baru dengan status 'Belum diverifikasi'
$query = "SELECT COUNT(DISTINCT report.id) AS new_reports FROM report WHERE status = 'Belum diverifikasi'";
$result = $db->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $new_reports = $row['new_reports'];
} else {
    $new_reports = 0;
}

// Simpan jumlah laporan dalam variabel global
$GLOBALS['new_reports'] = $new_reports;
?>