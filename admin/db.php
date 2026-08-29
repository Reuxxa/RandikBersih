<?php

$db =new mysqli("sql205.infinityfree.com","if0_42780279","7tNd1k6x85","if0_42780279_website_pelaporan_sampah");

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}else{
    //echo "Koneksi berhasil";
}