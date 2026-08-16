<?php
include 'conn.php';

if (empty($_POST["email"]) || empty($_POST["password"])) {
    die("Harap isi username dan password.");
}

$email = htmlspecialchars(trim($_POST["email"]), ENT_QUOTES, 'UTF-8');
$password = trim($_POST["password"]);

$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
        // Setelah login berhasil
        session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["user_logged_in"] = true; // Menyimpan status login
        echo "<script>alert('Login berhasil!'); window.location.href = 'homepage.php';</script>";
        exit();
    } else {
        echo "<script>alert('Password salah.'); window.location.href = 'homepage.php';</script>";
    }
} else {
    echo "<script>alert('Email tidak ditemukan.'); window.location.href = 'homepage.php';</script>";
}

$stmt->close();
$conn->close();
?>
