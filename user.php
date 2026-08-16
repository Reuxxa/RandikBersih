<?php
include 'conn.php'; // Hubungkan ke database

// Ambil data profil terbaru dari database
$sql = "SELECT * FROM profil_website ORDER BY id DESC LIMIT 1"; // Mengambil data terbaru berdasarkan ID
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data profil tidak ditemukan.";
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RandikBersih.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Roboto Slab', serif; background: #f3f8ff; margin: 0; padding: 0;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(to right, #66d3ff, #3399ff); padding: 10px 25px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: white; font-weight: bold; font-size: 26px;">
                <img src="asset/logo.png" alt="Logo" style="border-radius:15%; width:50px; height:auto; margin-right:10px;">
                RandikBersih.com
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php" style="color: white; font-size: 18px; padding: 12px 20px;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="user.php" style="color: white; font-size: 18px; padding: 12px 20px;">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php#TentangKami" style="color: white; font-size: 18px; padding: 12px 20px;">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php#Kontak" style="color: white; font-size: 18px; padding: 12px 20px;">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Header Section -->
    <header style="background: linear-gradient(135deg, #007acc, #3399ff); color: white; text-align: center; padding: 15px 20px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-size: 28px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">Profil Website</h1>
        <p style="font-size: 16px; margin-top: 10px; font-weight: 400;">Selamat datang di halaman profil website RandikBersih.com</p>
    </header>

    <!-- Profile Information Section -->
    <div style="max-width: 900px; margin: 40px auto; background: white; border-radius: 15px; padding: 30px 40px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #007acc; margin-bottom: 30px; font-size: 32px; font-weight: 700;">Informasi Website</h2>

        <!-- Profile Items -->
        <?php 
        $profileFields = [
            'Name Web' => $row['name_web'],
            'Judul' => $row['judul'],
            'Deskripsi' => $row['deskripsi'],
            'Keyword' => $row['keyword'],
            'Alamat' => $row['alamat'],
            'Phone' => $row['phone'],
            'Email' => $row['email'],
        ];
        foreach ($profileFields as $label => $value) {
            echo '
            <div style="margin-bottom: 20px; display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between;">
                <div style="width: 150px; font-weight: bold; color: #004d73; font-size: 18px; margin-bottom: 5px;">' . $label . '</div>
                <div style="flex-grow: 1; max-width: calc(100% - 160px); background: #f0f9ff; padding: 15px; border-radius: 8px; color: #007acc; font-size: 16px; font-weight: 500; overflow-wrap: break-word; word-break: break-word;">' . $value . '</div>
            </div>';
            }
        ?>
    </div>


    <!-- Social Media Section -->
    <div style="text-align: center; margin-top: 40px;">
        <h3 style="font-size: 28px; color: #007acc; font-weight: 700;">Ikuti Kami di Sosial Media</h3>
        <div style="margin-top: 20px;">
            <a href="https://www.instagram.com/asramarandik/?igsh=azlhcmI0Z2w3emJz#" target="_blank" style="color: #E4405F; font-size: 30px; margin: 0 20px;">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.tiktok.com/@asramaputrirandik?_t=8sU5e6C0zhg&_r=1" target="_blank" style="color: #000; font-size: 30px; margin: 0 20px;">
                <i class="fab fa-tiktok"></i>
            </a>
            <a href="https://www.facebook.com/profile.php?id=61553427238365&mibextid=ZbWKwL" target="_blank" style="color: #1877F2; font-size: 30px; margin: 0 20px;">
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, #3399ff, #007acc); color: white; text-align: center; padding: 25px 0; margin-top: 40px;">
        <p style="margin: 0; font-size: 16px;">&copy; <?php echo date("Y"); ?> RandikBersih.com. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
