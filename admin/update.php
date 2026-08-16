<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id'];
    $name_web = $_POST['name_web'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $keyword = $_POST['keyword'];
    $alamat = $_POST['alamat'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Query untuk memperbarui data
    $sql = "UPDATE profil_website SET 
        name_web = '$name_web', 
        judul = '$judul', 
        deskripsi = '$deskripsi', 
        keyword = '$keyword', 
        alamat = '$alamat', 
        phone = '$phone', 
        email = '$email' 
        WHERE id = $id";

    if ($db->query($sql) === TRUE) {
        // Redirect kembali ke halaman profil setelah update berhasil
        header("Location: profile.php"); // Mengarahkan kembali ke profil.php
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
?>


