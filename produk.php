<?php
    session_start();
    require "koneksi.php";

    $queryproduk = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahproduk = mysqli_num_rows($queryproduk);

    $querykategori = mysqli_query($conn, "SELECT * FROM Kategori");
    $queryukuran = mysqli_query($conn, "SELECT * FROM ukuran"); 

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <style>
/* General Styling */
body {
    font-family: 'Roboto', Arial, sans-serif;
    background-color: #f0f4f8; /* Light background for better contrast */
    color: #333;
    margin: 0;
    padding: 0;
}

h3, h2 {
    color: #2c3e50; /* Dark Blue for headings */
    font-weight: bold;
}

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
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    font-size: 1rem;
}

form label {
    font-weight: 600;
    color: #2c3e50;
}

form input, form select, form textarea {
    border: 1px solid #ced4da;
    border-radius: 8px;
    padding: 10px;
    width: 100%;
    margin-bottom: 15px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

form input:focus, form select:focus, form textarea:focus {
    border-color: #f7dc6f; /* Gold */
    box-shadow: 0 0 5px rgba(247, 220, 111, 0.5);
}

form button.btn-primary {
    background-color: #f7dc6f; /* Gold */
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

form button.btn-primary:hover {
    background-color: #d4ac0d; /* Darker Gold */
}

/* Table Styling */
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



/* Navbar Styling */
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


<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="index.php" class="text-muted"><i class="fa-solid fa-house"></i>Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Produk</li>
        </ol>
    </nav>

    <div class="my-5 col-12 col-md-6">
        <h3>Tambah Produk</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
            </div>
            <div>
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="">Pilih satu</option>
                    <?php 
                    while($data = mysqli_fetch_array($querykategori)){
                    ?>
                        <option value="<?php echo $data['id']?>"><?php echo $data['nama']?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="harga">Harga</label>
                <input type="number" class="form-control" name="harga" required>
            </div>
            <div>
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div>
                <label for="detail">Detail</label>
                <textarea name="detail" id="detail" rows="10" cols="10" class="form-control"></textarea>
            </div>
            <div>
                <label for="ketersediaan_stok">Ketersediaan Stok</label>
                <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
                <div>
    <label for="ukuran">Ukuran</label>
    <div class="form-check">
        <?php
        // Loop through the sizes and create a checkbox for each one
        while ($size = mysqli_fetch_array($queryukuran)) {
            echo "<div class='form-group'>";
            echo "<input type='checkbox' class='form-check-input' name='ukuran[]' value='{$size['id']}' id='ukuran{$size['id']}'>";
            echo "<label class='form-check-label' for='ukuran{$size['id']}'>{$size['nama']}</label>";
            echo "<input type='number' name='stok_ukuran[{$size['id']}]' placeholder='Stok ukuran {$size['nama']}' class='form-control mt-2' min='0'>";
            echo "</div><br>";
        }
        ?>
    </div>
</div>

                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            </div>
        </form>

        <?php
    if (isset($_POST['simpan'])) {
        $nama = htmlspecialchars($_POST['nama']);
        $kategori = htmlspecialchars($_POST['kategori']);
        $harga = htmlspecialchars($_POST['harga']);
        $detail = htmlspecialchars($_POST['detail']);
        $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);
        $ukuran = $_POST['ukuran']; // Ini adalah array, tidak perlu di htmlspecialchars
        $stok_ukuran = $_POST['stok_ukuran']; // Ini adalah array stok berdasarkan ukuran
        
        $target_dir = "image/";
        $nama_file = basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];
        $random_name = generateRandomString(20);
        $new_name = $random_name . "." . $imageFileType;
    
        // Validasi input
        if (empty($nama) || empty($kategori) || empty($harga)) {
            echo '<div class="alert alert-danger mt-3" role="alert">Nama, kategori, dan harga wajib diisi.</div>';
        } else {
            if (!empty($nama_file)) {
                if ($image_size > 500000) {
                    echo '<div class="alert alert-warning mt-3" role="alert">Foto tidak boleh lebih dari 500KB.</div>';
                } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo '<div class="alert alert-warning mt-3" role="alert">File harus berupa JPG, JPEG, PNG, atau GIF.</div>';
                } else {
                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name)) {
                        $querytambah = mysqli_query($conn, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");
                        if ($querytambah) {
                            $produk_id = mysqli_insert_id($conn);
                            
                            // Menyimpan data ukuran dan stok untuk produk yang baru ditambahkan
                            foreach ($ukuran as $id_ukuran) {
                                $stok = isset($stok_ukuran[$id_ukuran]) && is_numeric($stok_ukuran[$id_ukuran]) ? $stok_ukuran[$id_ukuran] : 0; // Ambil stok dari form, jika tidak ada, set 0
                                $queryukuran_insert = mysqli_query($conn, "INSERT INTO produk_ukuran (produk_id, ukuran_id, stok) VALUES ('$produk_id', '$id_ukuran', '$stok')");
                            }
    
                            echo '<div class="alert alert-success mt-3" role="alert">Produk berhasil disimpan.</div>';
                            echo '<meta http-equiv="refresh" content="2;url=produk.php">';
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Gagal menyimpan produk: ' . mysqli_error($conn) . '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger mt-3" role="alert">Gagal mengunggah foto.</div>';
                    }
                }
            } else {
                $querytambah = mysqli_query($conn, "INSERT INTO produk (kategori_id, nama, harga, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$detail', '$ketersediaan_stok')");
                if ($querytambah) {
                    $produk_id = mysqli_insert_id($conn);
    
                    // Menyimpan data ukuran dan stok untuk produk yang baru ditambahkan
                    foreach ($ukuran as $id_ukuran) {
                        $stok = isset($stok_ukuran[$id_ukuran]) && is_numeric($stok_ukuran[$id_ukuran]) ? $stok_ukuran[$id_ukuran] : 0; // Ambil stok dari form, jika tidak ada, set 0
                        $queryukuran_insert = mysqli_query($conn, "INSERT INTO produk_ukuran (produk_id, ukuran_id, stok) VALUES ('$produk_id', '$id_ukuran', '$stok')");
                    }
    
                    echo '<div class="alert alert-success mt-3" role="alert">Produk berhasil disimpan tanpa foto.</div>';
                    echo '<meta http-equiv="refresh" content="2;url=produk.php">';
                } else {
                    echo '<div class="alert alert-danger mt-3" role="alert">Gagal menyimpan produk: ' . mysqli_error($conn) . '</div>';
                }
            }
        }
    }
?>

    </div>
</div>
<div class="mt-3 mb-5">
    <h2>List Produk</h2>
    <div class="table-responsive mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Ketersediaan Stok</th>
                    <th>Ukuran</th>
                    <th>Stok Ukuran</th> <!-- Added column for stock -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($jumlahproduk == 0) {
                    echo "<tr><td colspan='8' class='text-center'>Data produk tidak ada</td></tr>";
                } else {
                    $jumlah = 1;
                    while ($data = mysqli_fetch_array($queryproduk)) {
                        // Fetching associated sizes and their stock
                        $produk_id = $data['id'];
                        $queryukuranproduk = mysqli_query($conn, "
                            SELECT u.nama, pu.stok 
                            FROM ukuran u 
                            JOIN produk_ukuran pu ON u.id = pu.ukuran_id
                            WHERE pu.produk_id = $produk_id
                        ");
                        $ukuran_list = [];
                        $stok_list = [];
                        while ($ukuran = mysqli_fetch_array($queryukuranproduk)) {
                            $ukuran_list[] = $ukuran['nama'];
                            $stok_list[] = $ukuran['stok']; // Collect the stock for each size
                        }
                        $ukuran_display = implode(", ", $ukuran_list); // Joining sizes with a comma
                        $stok_display = implode(", ", $stok_list); // Joining stocks with a comma
                        ?>
                        <tr>
                            <td><?php echo $jumlah; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['nama_kategori']; ?></td>
                            <td><?php echo $data['harga']; ?></td>
                            <td><?php echo $data['ketersediaan_stok']; ?></td>
                            <td><?php echo $ukuran_display; ?></td>
                            <td><?php echo $stok_display; ?></td> <!-- Display the stock for each size -->
                            <td>
                                <a href="produk-detail.php?x=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i></a>
                                <a href="produk-hapus.php?id=<?php echo $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"><i class="fa-solid fa-trash"></i></a>
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



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>