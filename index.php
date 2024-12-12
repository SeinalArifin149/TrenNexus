<?php
session_start();
require "koneksi.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href = 'login.php';</script>";
    exit;
}

// Query data kategori dan produk
$querykategori = mysqli_query($conn, "SELECT * FROM Kategori");
$jumlahkategori = mysqli_num_rows($querykategori);
$queryproduk = mysqli_query($conn, "SELECT * FROM produk");
$jumlahproduk = mysqli_num_rows($queryproduk);
$queryuser = mysqli_query($conn, "SELECT * FROM users");
$jumlahuser = mysqli_num_rows($queryuser);


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <title>Home</title>
    <style>
  /* Warna dasar untuk kategori dan produk */
  .sunmary-kategori {
    background: linear-gradient(135deg, #1e90ff, #87ceeb);
    border-radius: 15px;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .sunmary-produk {
    background: linear-gradient(135deg, #ff8c00, #ffa500);
    border-radius: 15px;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  /* Efek hover untuk kategori dan produk */
  .sunmary-kategori:hover, .sunmary-produk:hover, .sunmary-user:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  }

  /* Ikon besar lebih menarik */
  .sunmary-kategori i, .sunmary-produk i , .sunmary-user i {
    color: rgba(255, 255, 255, 0.7);
  }

  /* Link dalam box */
  .sunmary-kategori a, .sunmary-produk a, .sunmary-user a {
    color: white;
    text-decoration: underline;
  }

  .sunmary-kategori a:hover, .sunmary-produk a:hover, .sunmary-user a:hover {
    text-decoration: none;
    font-weight: bold;
  }

  /* Breadcrumb Styling */
  .breadcrumb {
    background-color: #f8f9fa;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 8px 15px;
  }

  .breadcrumb .breadcrumb-item a {
    text-decoration: none;
    color: #007bff;
  }

  .breadcrumb .breadcrumb-item a:hover {
    text-decoration: underline;
  }

  /* Navbar Styling */
  .navbar {
    background: linear-gradient(90deg, #1e3c72, #2a5298);
  }

  .navbar-brand {
    font-weight: bold;
    color: #f0f8ff;
    transition: color 0.3s ease;
  }

  .navbar-brand:hover {
    color: #00d1b2;
  }

  .navbar-nav .nav-link {
    color: #dcdcdc;
    transition: color 0.3s ease;
  }

  .navbar-nav .nav-link:hover {
    color: #ffffff;
  }

  .btn-primary {
    background-color: #007bff;
    border: none;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    transform: scale(1.05);
  }

  /* Media Query untuk Responsiveness */
  @media (max-width: 768px) {
    .breadcrumb {
      text-align: center;
    }

    .sunmary-kategori, .sunmary-produk {
      text-align: center;
    }

    .sunmary-kategori i, .sunmary-produk i {
      margin-bottom: 10px;
    }
  }

  nav.navbar {
    background-color: #34495e; /* Dark Blue */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease; /* Smooth transition for hover effects */
}

/* Navbar Hover Animation */
nav.navbar:hover {
    background-color: #2c3e50; /* Slightly Darker Blue */
    transform: translateY(-5px); /* Lift navbar slightly */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); /* More prominent shadow */
}

.sunmary-user {
    background: linear-gradient(135deg, #044cdb, #525cdf);
    border-radius: 15px;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
</style>

  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <img src="logo.png" alt="Logo" width="40" class="d-inline-block align-text-top">
      TRENNEXUS
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-uppercase" href="index.php">
            <i class="fas fa-home me-2"></i>Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" href="kategori.php">
            <i class="fas fa-th-list me-2"></i>Kategori
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" href="produk.php">
            <i class="fas fa-box-open me-2"></i>Produk
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" href="user.php">
          <i class="fa-solid fa-user "></i>user
          </a>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary btn-sm px-4 rounded-pill text-uppercase" href="logout.php">
            Logout <i class="fas fa-sign-out-alt ms-2"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    <div class="container mt-5">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-house"></i> Home</li>
        </ol>
      </nav>
      <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

      <div class="container mt-5">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="sunmary-kategori p-3">
              <div class="row">
                <div class="col-6">
                  <i class="fa-solid fa-align-justify fa-7x"></i>
                </div>
                <div class="col-6">
                  <h3>KATEGORI</h3>
                  <p class="fs-2"><?php echo $jumlahkategori; ?> Kategori</p>
                  <p class="fs-4"><a href="kategori.php" class="text_decoration">Lihat Details</a></p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="sunmary-produk p-3">
              <div class="row">
                <div class="col-6">
                  <i class="fa-solid fa-box fa-7x"></i>
                </div>
                <div class="col-6">
                  <h3>PRODUK</h3>
                  <p class="fs-2"><?php echo $jumlahproduk; ?> Produk</p>
                  <p class="fs-4"><a href="produk.php" class="text_decoration">Lihat Details</a></p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="sunmary-user p-3">
              <div class="row">
                <div class="col-6">
                <i class="fa-solid fa-user fa-7x"></i>
                </div>
                <div class="col-6">
                  <h3>USER</h3>
                  <p class="fs-2"><?php echo $jumlahuser; ?> USER</p>
                  <p class="fs-4"><a href="user.php" class="text_decoration">Lihat Details</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
  </body>
</html>
