<?php
session_start();
require "koneksi.php"; // Pastikan file koneksi.php benar dan $conn sudah terdefinisi

// Mendapatkan ID dari URL
$id = isset($_GET['x']) ? (int)$_GET['x'] : 0;

// Jika ID tidak valid, redirect ke halaman kategori
if ($id <= 0) {
    header("Location: kategori.php");
    exit();
}

// Ambil data kategori berdasarkan ID
$query = mysqli_prepare($conn, "SELECT * FROM kategori WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_array($result);

if (!$data) {
    echo "<div class='alert alert-danger mt-3'>Kategori tidak ditemukan!</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <style>
        /* General Styling */
        body {
            background-color: #f4f4f9;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(90deg, #1e3c72, #2a5298); /* Gradient background */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Shadow for a modern look */
        }

        .navbar-brand {
            font-weight: bold;
            color: #f0f8ff;
            font-size: 1.5rem; /* Bigger font size for brand */
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: #00d1b2; /* Highlight on hover */
        }

        .navbar-nav .nav-link {
            color: #dcdcdc;
            font-size: 1rem;
            transition: color 0.3s ease;
            margin-right: 10px;
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff; /* Bright white on hover */
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(255, 255, 255, 0.3);
        }

        .btn-primary {
            border-radius: 8px;
            padding: 8px 20px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #c0392b; /* Slightly darker red */
            transform: scale(1.1); /* Enlarge on hover */
        }

        /* Container Styling */
        .container {
            margin-top: 3rem;
            max-width: 600px;
            background: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 1.5rem;
        }

        form {
            font-size: 1rem;
        }

        form label {
            font-weight: 600;
            color: #495057;
        }

        form input,
        form select {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        form input:focus,
        form select:focus {
            border-color: #4c6ef5;
            box-shadow: 0px 0px 8px rgba(76, 110, 245, 0.3);
        }

        form button {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-danger {
            background: #ff6f61;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #e63946;
            transform: scale(1.05);
        }

        .btn-secondary {
            background: #adb5bd;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #6c757d;
            transform: scale(1.05);
        }

        /* Alert Styling */
        .alert {
            border-radius: 10px;
            padding: 15px;
            font-size: 0.95rem;
            margin-top: 1rem;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .container {
                padding: 1.5rem;
            }

            form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
  <div class="container">
    <a class="navbar-brand" href="index.php">BrandName</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php"><i class="fas fa-home me-2"></i>Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kategori.php"><i class="fas fa-th-list me-2"></i>Kategori</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="produk.php"> <i class="fas fa-box-open me-2"></i>Produk</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-danger text-white" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
    <div class="col-12 col-md-6">
        <h3>Kategori Detail</h3>
        <form action="" method="post">
            <div>
                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo htmlspecialchars($data['nama']); ?>">
            </div>
            <div class="mt-5 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                <button type="submit" class="btn btn-danger" name="delete">Hapus</button>
                <a href="kategori.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        <?php
        // Proses Edit
        if (isset($_POST['editBtn'])) {
            $kategori = htmlspecialchars($_POST['kategori']);

            if ($kategori === $data['nama']) {
                echo "<div class='alert alert-info mt-3'>Data kategori tidak mengalami perubahan</div>";
            } else {
                // Cek apakah kategori sudah ada
                $stmt = mysqli_prepare($conn, "SELECT id FROM kategori WHERE nama = ? AND id != ?");
                mysqli_stmt_bind_param($stmt, "si", $kategori, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    echo "<div class='alert alert-warning mt-3'>Kategori sudah ada</div>";
                } else {
                    // Update kategori
                    $stmt = mysqli_prepare($conn, "UPDATE kategori SET nama = ? WHERE id = ?");
                    mysqli_stmt_bind_param($stmt, "si", $kategori, $id);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<div class='alert alert-success mt-3'>Kategori berhasil diupdate</div>";
                        echo "<meta http-equiv='refresh' content='1;url=kategori.php'>";
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Gagal mengupdate kategori</div>";
                    }
                }
            }
        }

        // Proses Hapus
        if (isset($_POST['delete'])) {
            // Cek apakah ada produk yang menggunakan kategori ini
            $querycheck = mysqli_prepare($conn, "SELECT id FROM produk WHERE kategori_id = ?");
            mysqli_stmt_bind_param($querycheck, "i", $id);
            mysqli_stmt_execute($querycheck);
            mysqli_stmt_store_result($querycheck);

            if (mysqli_stmt_num_rows($querycheck) > 0) {
                echo "<div class='alert alert-warning mt-3'>Data tidak bisa dihapus karena sudah ada produk</div>";
            } else {
                $querydelete = mysqli_prepare($conn, "DELETE FROM kategori WHERE id = ?");
                mysqli_stmt_bind_param($querydelete, "i", $id);
                if (mysqli_stmt_execute($querydelete)) {
                    echo "<div class='alert alert-success mt-3'>Kategori berhasil dihapus</div>";
                    echo "<meta http-equiv='refresh' content='1;url=kategori.php'>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Gagal menghapus kategori</div>";
                }
            }
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
