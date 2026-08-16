<?php
include 'db.php';

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek apakah semua field sudah diisi
    if (empty($_POST["name"]) || empty($_POST["password"]) || empty($_POST["confirmPass"])) {
        echo "<script>alert('Harap isi semua data.'); window.location.href = 'register.php';</script>";
        exit;
    }

    // Ambil input dan sanitasi
    $name = htmlspecialchars(trim($_POST["name"]), ENT_QUOTES, 'UTF-8');
    $password = trim($_POST["password"]);
    $confirmPass = trim($_POST["confirmPass"]);

    // Validasi apakah password dan konfirmasi password sama
    if ($password !== $confirmPass) {
        echo "<script>alert('Registrasi gagal. Password dan konfirmasi password tidak cocok.'); window.location.href = 'register.php';</script>";
        exit;
    }

    // Validasi panjang password
    if (strlen($password) < 8) {
        echo "<script>alert('Registrasi gagal. Password harus lebih dari 8 karakter.'); window.location.href = 'register.php';</script>";
        exit;
    }

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah terdaftar
    $sql_check = "SELECT * FROM admin WHERE name = ?";
    $stmt_check = $db->prepare($sql_check);
    $stmt_check->bind_param("s", $name);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    // Jika username sudah ada, tampilkan pesan kesalahan
    if ($result->num_rows > 0) {
        echo "<script>alert('Nama Pengguna sudah digunakan. Silakan pilih yang lain.'); window.location.href = 'register.php';</script>";
        exit;
    } else {
        // Jika validasi sukses, simpan data ke database
        $sql_insert = "INSERT INTO admin (name, password) VALUES (?, ?)";
        $stmt_insert = $db->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $name, $hashed_password);

        if ($stmt_insert->execute()) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal. Silakan coba lagi.'); window.location.href = 'register.php';</script>";
            error_log("Database error: " . $stmt_insert->error);
        }
    }

    $stmt_check->close();
    $stmt_insert->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Buat akun baru!</h1>
                                    </div>
                                    <form class="user" method="POST" action="register.php">
                                        <div class="mb-3">
                                            <label for="exampleInputName1" class="form-label">Nama</label>
                                            <input type="text" class="form-control form-control-user" name="name" id="exampleInputName1" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword" class="form-label">Konfirmasi Ulang Password</label>
                                            <input type="password" class="form-control form-control-user" id="exampleInputConfirmPassword" name="confirmPass" placeholder="Konfirmasi Ulang Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Sudah punya akun? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
