<?php
session_start();
require "koneksi.php";

$queryUsers = mysqli_query($conn, "SELECT * FROM users");
$jumlahUsers = mysqli_num_rows($queryUsers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <title>Manajemen Users</title>
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
    <li class="breadcrumb-item active" aria-current="page">
    <a href="index.php" class="text_decoration text-muted"><i class="fa-solid fa-house"></i>Home</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
    user
    </li>
  </ol>
</nav>
    <h3>Tambah User</h3>
    <form action="" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="no_telp" class="form-label">No Telp</label>
            <input type="number" id="no_telp" name="no_telp" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" rows="4" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-control">
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit" name="simpan_user">Simpan</button>
    </form>

    <?php
    if (isset($_POST['simpan_user'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $no_telp = htmlspecialchars($_POST['no_telp']);
        $email = htmlspecialchars($_POST['email']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $role = htmlspecialchars($_POST['role']);

        $stmt = mysqli_prepare($conn, "SELECT username FROM users WHERE username=? OR email=?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo '<div class="alert alert-warning mt-3">Username atau Email sudah ada</div>';
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, no_telp, email, alamat, role) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssss", $username, $password, $no_telp, $email, $alamat, $role);
            $querySimpan = mysqli_stmt_execute($stmt);

            if ($querySimpan) {
                echo '<div class="alert alert-success mt-3">User berhasil ditambahkan</div>';
                echo '<meta http-equiv="refresh" content="1; url=user.php" />';
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
    ?>

<h2 class="mt-5">List Users</h2>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($jumlahUsers == 0) {
                echo '<tr><td colspan="7" class="text-center">Data user tidak ada</td></tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_array($queryUsers)) {
                    echo '<tr>';
                    echo "<td>{$no}</td>";
                    echo "<td>{$data['username']}</td>";
                    echo "<td>{$data['no_telp']}</td>";
                    echo "<td>{$data['email']}</td>";
                    echo "<td>{$data['alamat']}</td>";
                    echo "<td>{$data['role']}</td>";
                    echo '<td>';
                    echo '<a href="user-detail.php?x=' . $data['id'] . '" class="btn btn-info btn-sm">Detail</a>';
                    echo ' <a href="user-edit.php?x=' . $data['id'] . '" class="btn btn-warning btn-sm">Edit</a>';
                    echo ' <a href="user-delete.php?x=' . $data['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>