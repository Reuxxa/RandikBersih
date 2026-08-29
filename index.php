<?php
include 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  // Mendapatkan data dari form
  $jenis_sampah = $_POST['jenis_sampah'];
  $deskripsi = $_POST['deskripsi']; // Misalnya deskripsi
  $id_user = $_SESSION["user_id"]; // Pastikan id_user ada di form
  $id_lokasi = $_POST['lokasi']; // Pastikan id_lokasi ada di form

  // Proses upload file
  $target_dir = "asset/uploads/";
  $target_file = $target_dir . basename($_FILES["foto"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["foto"]["name"])) . " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }

  // Query untuk insert ke tabel 'report'
  $stmt1 = $conn->prepare("INSERT INTO report (id_user, id_lokasi, photo, deskripsi) VALUES (?,  ?, ?, ?)");
  $stmt1->bind_param("iiss", $id_user, $id_lokasi, $target_file, $deskripsi);

  // Eksekusi query pertama (insert ke report)
  if ($stmt1->execute()) {
    // Ambil ID terakhir yang dimasukkan (id_report) dari query pertama
    $last_id = $conn->insert_id; // Ini adalah ID yang baru saja dimasukkan ke tabel 'report'

    // Query untuk insert ke tabel 'detail_report' menggunakan id_report yang baru
    $stmt2 = $conn->prepare("INSERT INTO detail_report (id_report, id_jenis_sampah, jumlah) VALUES (?, ?, ?)");
    $stmt2->bind_param("iii", $last_id, $jenis_sampah, $_POST['jumlah']); // Asumsikan 'jumlah' ada di form

    if ($stmt2->execute()) {
      header("Location: homepage.php");
      exit();
    } else {
      echo "Data Gagal Ditambahkan ke detail_report";
      exit();
    }
  } else {
    echo "Data Gagal Ditambahkan ke report";
    exit();
  }
}

$sql = "SELECT * FROM profil_website ORDER BY id DESC LIMIT 1"; // Mengambil data terbaru berdasarkan ID
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $phone = $row['phone'];
    $email_web = $row['email'];
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
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Roboto Slab', serif; background: #f3f8ff; margin: 0; padding: 0;">
  <!--Navbar-->
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
            <a class="nav-link active" href="homepage.php" style="color: white; font-size: 18px; padding: 12px 20px;">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="user.php" style="color: white; font-size: 18px; padding: 12px 20px;">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#TentangKami" style="color: white; font-size: 18px; padding: 12px 20px;">Tentang Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#Kontak" style="color: white; font-size: 18px; padding: 12px 20px;">Kontak</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <header
    class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between px-4 py-5">
    <div>
      <div class="bg" style="background-image: url('asset/image.png')"></div>
      <h1 style="color:white">Satu laporan bisa membuat perubahan besar! </h1>
      <p style="color:white">Laporkan sampah yang kamu temui dan jadilah bagian dari solusi!</p>
      <button type="button" class="btn btn-primary" style="background: linear-gradient(to right, #66c2ff, #3399ff);" onclick="displayForm()">
        Laporkan Sekarang!
      </button>
    </div>
    <img src="asset/hero1.png" alt="Hero Image" class="col-8 col-md-5 col-lg-3">
  </header>
  <!-- cms -->
  <section>
    <div class="text-center mt-4">
      <h1>Laporan Sampah Terverifikasi</h1>
    </div>
    <div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-center px-4 gap-4">
      <?php
        $q = "SELECT * FROM report AS r INNER JOIN lokasi AS l WHERE r.id_lokasi=l.id AND status <> 'Belum diverifikasi' AND status <> 'Ditolak'";
        $result = $conn->query($q);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<div class="card card-sampah" style="width: 18rem; transition: transform 0.3s ease, box-shadow 0.3s ease;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Lokasi: ' . $row['nama_lokasi'] . '</h5>';
            echo '<img src="' . $row['photo'] . '" style="width: 100%; height: 100%">';
            echo '<h6 class="card-subtitle mb-2 text-body-secondary">Tanggal: ' . $row['update_at'] . '</h6>';
            echo '<p class="card-text">' . $row['deskripsi'] .'</p>';
            echo '<span class="badge text-bg-success">' . $row['status'] . '</span>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo 'Belum ada data';
        }
      ?>
    </div>
  </section>

  <!-- laman login daftar -->
  <section>
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-5 px-4 py-4" id="logindaftar" style="background: linear-gradient(to right, #66d3ff, #3399ff);">
      <h1 class="text-center text-md-start ft-1">Laporkan sampah, <br> jadilah bagian dari solusi!</h1>
      <div>
        <!-- Button formulir login -->
        <button type="button" class="btn btn-primary" style="background: linear-gradient(to right, #66c2ff, #3399ff);" data-bs-toggle="modal" data-bs-target="#login">
          Login
        </button>
        <!-- Button formulir daftar -->
        <button type="button" class="btn btn-primary" style="background: linear-gradient(to right, #66c2ff, #3399ff);" data-bs-toggle="modal" data-bs-target="#daftar">
          Daftar
        </button>
        <!-- Button formulir logout -->
        <button type="button" class="btn btn-primary" style="background: linear-gradient(to right, #66c2ff, #3399ff);" data-bs-toggle="modal" data-bs-target="#logoutModal">
          Logout
        </button>
      </div>
    </div>
  </section>
  <!-- Form report -->
  <section id="form-section" class="<?php echo isset($_SESSION['user_logged_in']) ? '' : 'd-none'; ?>">
    <div class="mt-5 px-4" style="background: radial-gradient(circle, #d3f0ff, #80d8ff);">
      <form method="post" action="" enctype="multipart/form-data">
        <br>
        <h1>Ayo Laporkan Sampah Yang Kamu Temui!</h1>
        <div class="mb-3">
          <label for="exampleInputJenis1" class="form-label"><br>Jenis Sampah</label>
          <select class="form-select" name="jenis_sampah" aria-label="Default select example">
            <option></option>;
            <?php
            $q = "select * from jenis_sampah";
            $result = $conn->query($q);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['nama_jenis'] . '</option>';
              }
            } else {
              echo "0 result";
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputJumlah1" class="form-label">Jumlah Sampah</label>
          <input type="text" class="form-control" name="jumlah" id="exampleInputJumlah1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputLokasi1" class="form-label">Lokasi</label>
          <select class="form-select" name="lokasi" aria-label="Default select example">
            <option></option>;
            <?php
            $q = "select * from lokasi";
            $result = $conn->query($q);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['nama_lokasi'] . '</option>';
              }
            } else {
              echo "0 result";
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputDesc1" class="form-label">Deskripsi</label>
          <input type="text" class="form-control" name="deskripsi" id="exampleInputDesc1" style="height: 100px">
        </div>
        <div class="mb-3">
          <label for="exampleInputFoto1" class="form-label">Lampirkan Foto *opsional</label>
          <input type="file" class="form-control" name="foto" id="exampleInputFoto1" aria-describedby="emailHelp">
        </div>
        <!-- <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Sembunyikan Identitas</label>
        </div> -->
        <button type="submit" class="btn btn-primary" style="background: linear-gradient(to left, #a3d9ff, #66c4ff);">Submit</button>
      </form>
      <br>
    </div>
  </section>

  <!-- Tentang kami -->
  <section>
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-4 px-4">
      <div class="col-12 col-md-4 mb-4 mb-md-0" id="TentangKami">
        <h3>Tentang Kami</h3>
        <p>Kami hadir untuk mendukung kebersihan dan kenyaman sekitar Asrama Putri Randik. Melalui pelaporan sampah, kami berupaya menjaga kelestarian lingkungan. Kami percaya bahwa lingkungan yang bersih adalah tanggung jawab bersama, untuk dinikmati oleh semua generasi.</p>
      </div>
      <div class="col-12 col-md-4" id="Kontak">
        <h3>Kontak</h3>
        <p>Asrama Putri Randik Kab. Musi Banyuasin <br> <?php echo $phone ?> <br> <?php echo $email_web ?></p>
        <a href="user.php">Informasi lebih lanjut</a>
      </div>
    </div>
  </section>
  <!-- Formulir Login -->
  <div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Login</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="login.php">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            </div>
        </div>
        <div class="modal-footer justify-content-start">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="#" data-bs-toggle="modal" data-bs-target="#daftar">Belum punya akun? daftar</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Formulir Daftar -->
  <div class="modal fade" id="daftar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Daftar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="daftar.php">
            <div class="mb-3">
              <label for="exampleInputName1" class="form-label">Name</label>
              <input type="text" class="form-control" name="name" id="exampleInputName1">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword2" class="form-label">Konfirmasi Password</label>
              <input type="password" class="form-control" name="confirmPass" id="exampleInputPassword2" required>
              <div id="passwordError" class="form-text text-danger" style="display: none;">Password tidak cocok. Silahkan coba lagi.</div>
            </div>
        </div>
        <div class="modal-footer justify-content-start">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="#" data-bs-toggle="modal" data-bs-target="#login">Sudah punya akun? login</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin logout?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Pilih logout untuk keluar dari sesi.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form method="POST" action="logout.php">
            <button type="submit" class="btn btn-primary">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script>
    function displayForm() {
      // Periksa apakah pengguna sudah login
      <?php if (isset($_SESSION['user_logged_in'])) { ?>
        let formSection = document.getElementById('form-section');
        formSection.classList.toggle('d-none');
        formSection.scrollIntoView();
      <?php } else { ?>
        // Jika pengguna belum login, scroll ke bagian login/daftar
        window.location.href = "#logindaftar"; // Arahkan ke bagian login/daftar
        alert("Silakan login terlebih dahulu untuk melaporkan sampah.");
      <?php } ?>
    }
    document.querySelectorAll('.card-sampah').forEach((el) => {
      el.addEventListener('mouseenter', () => {
        el.style.transform='translateY(-5px)';
        el.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)';
      })
      el.addEventListener('mouseleave', () => {
        el.style.transform='';
        el.style.boxShadow='';
      })
    })
  </script>
</body>

</html>
