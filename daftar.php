<?php
include 'conn.php';

// Cek apakah semua field sudah diisi
if (empty($_POST["name"]) || empty($_POST["password"]) || empty($_POST["email"]) || empty($_POST["confirmPass"])) {
    die("Harap isi semua data.");
}

// Ambil input dan sanitasi
$name = htmlspecialchars(trim($_POST["name"]), ENT_QUOTES, 'UTF-8');
$password = trim($_POST["password"]);
$confirmPass = trim($_POST["confirmPass"]);
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

// Validasi format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Registrasi gagal. Format email tidak valid.'); window.location.href = 'homepage.php';</script>";
    exit;
}

// Validasi apakah password dan konfirmasi password sama
if ($password !== $confirmPass) {
    echo "<script>alert('Registrasi gagal. Password dan konfirmasi password tidak cocok.'); window.location.href = 'homepage.php';</script>";
    exit;
}

// Validasi panjang password
if (strlen($password) < 8) {
    echo "<script>alert('Registrasi gagal. Password harus lebih dari 8 karakter.'); window.location.href = 'homepage.php';</script>";
    exit;
}

// Hash password sebelum disimpan ke database
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah username atau email sudah terdaftar
$sql_check = "SELECT * FROM user WHERE name = ? OR email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $name, $email);
$stmt_check->execute();
$result = $stmt_check->get_result();

// Jika username atau email sudah ada, tampilkan pesan kesalahan
if ($result->num_rows > 0) {
    echo "<script>alert('Nama Pengguna atau Email sudah digunakan. Silakan pilih yang lain.'); window.location.href = 'homepage.php';</script>";
    exit;
} else {
    // Jika validasi sukses, simpan data ke database
    $sql_insert = "INSERT INTO user (name, password, email) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $name, $hashed_password, $email);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = 'homepage.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal. Silakan coba lagi.'); window.location.href = 'homepage.php';</script>";
        error_log("Database error: " . $stmt_insert->error);
    }
}

$stmt_check->close();
$stmt_insert->close();
$conn->close();
?>
