<?php
    session_start();
    require "koneksi.php";

    $querykategori = mysqli_query($conn, "SELECT * FROM Kategori");
    $jumlahkategori = mysqli_num_rows($querykategori);
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

    <title>Document</title>
    <style>
  /* Navbar Styling */
  .sunmary-kategori:hover, .sunmary-produk:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  }

  /* Ikon besar lebih menarik */
  .sunmary-kategori i, .sunmary-produk i {
    color: rgba(255, 255, 255, 0.7);
  }

  /* Link dalam box */
  .sunmary-kategori a, .sunmary-produk a {
    color: white;
    text-decoration: underline;
  }

  .sunmary-kategori a:hover, .sunmary-produk a:hover {
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

  /* Form Styling */
  form {
      background: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  form label {
      font-weight: bold;
      color: #495057;
  }
  form .form-control {
      border: 1px solid #ced4da;
      border-radius: 8px;
  }
  form .form-control:focus {
      border-color: #ffc107;
      box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
  }
  form button.btn-primary {
      background-color: #ffc107;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      transition: background-color 0.3s ease, transform 0.3s ease;
  }
  form button.btn-primary:hover {
      background-color: #e0a800;
      transform: scale(1.05);
  }

  /* Table Styling */
  .table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
      background: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  .table th {
      background-color: #343a40;
      color: #ffffff;
      text-align: center;
      padding: 12px;
  }
  .table td {
      text-align: center;
      padding: 12px;
  }
  .table tbody tr {
      transition: background-color 0.3s ease;
  }
  .table tbody tr:hover {
      background-color: #f8f9fa;
  }

  /* Action Buttons */
  a.btn-info {
      background-color: #17a2b8;
      border: none;
      padding: 5px 10px;
      font-size: 14px;
      color: #ffffff;
      transition: background-color 0.3s ease, transform 0.3s ease;
  }
  a.btn-info:hover {
      background-color: #138496;
      transform: scale(1.1);
  }

  /* Alerts */
  .alert {
      border-radius: 10px;
      padding: 15px;
      font-size: 14px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }

  /* Mobile Adjustments */
  @media (max-width: 768px) {
      nav.navbar .navbar-brand {
          font-size: 1.2rem;
      }
      form {
          padding: 15px;
      }
      .table th, .table td {
          font-size: 0.9rem;
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


</div>
<div class="container mt-5">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">
    <a href="index.php" class="text_decoration text-muted"><i class="fa-solid fa-house"></i>Home</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
    kategori
    </li>
  </ol>
</nav>

<div class="my-5 col-12 col-md-6">
  <h3>Tambah Kategori</h3>

  <form action="" method="post">
    <div>
      <label for="Kategori">Kategori</label>
      <input type="text" id="kategori" name="kategori" placeholder="kategori" class="form-control">
    </div>
    <div class="mt-3">
      <button class="btn btn-primary" type="submit" name="simpan_kategori">simpan</button>
    </div>
  </form>
  <?php 

if (isset($_POST['simpan_kategori'])) {
  $kategori = htmlspecialchars($_POST['kategori']);

  if (!$conn) {
      die("Koneksi ke database gagal. Periksa konfigurasi database.");
  }

  $stmt = mysqli_prepare($conn, "SELECT nama FROM kategori WHERE nama=?");
  mysqli_stmt_bind_param($stmt, "s", $kategori);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $jumlahkategoribaru = mysqli_stmt_num_rows($stmt);

  if ($jumlahkategoribaru > 0) {
      echo '<div class="alert alert-warning mt-3" role="alert">Kategori sudah ada</div>';
  } else {
      $stmt = mysqli_prepare($conn, "INSERT INTO kategori (nama) VALUES (?)");
      mysqli_stmt_bind_param($stmt, "s", $kategori);
      $querysimpan = mysqli_stmt_execute($stmt);

      if ($querysimpan) {
          echo '<div class="alert alert-success mt-3" role="alert">Kategori berhasil ditambahkan</div>';
          echo '<meta http-equiv="refresh" content="1; url=kategori.php" />';
      } else {
          echo "Error: " . mysqli_error($conn);
      }
  }
}
?>
</div>
<div class="mt-3">
    <h2>list kategori</h2>

    <div class="table-responsive mt-5">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Nama</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                    if ($jumlahkategori==0){
                ?>
                        <tr>
                            <td colspan="3" class="text-center"> Data kategori tidak ada</td>
                        </tr>
                <?php
                    }
                    else{
                        $jumlah=1;
                        while($data=mysqli_fetch_array($querykategori)){
                ?>
                            <tr>
                                <td><?php echo $jumlah;?></td>
                                <td><?php echo $data['nama'];?></td>
                                <td>
                                  <a href="kategori-detail.php?x=<?php echo $data['id'];?>" class="btn btn-info" > <i class="fa-solid fa-magnifying-glass"></i></a>
                                </td>
                            </tr>
                <?php
                        $jumlah++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>