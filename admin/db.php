<?php

$db =new mysqli("localhost","root","","website_pelaporan_sampah");

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}else{
    //echo "Koneksi berhasil";
}