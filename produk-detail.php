<?php
    // session_start();
    require "koneksi.php";


    $id = $_GET['x'];

    $query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $querykategori = mysqli_query($conn, "SELECT * FROM Kategori WHERE id!='$data[kategori_id]'");

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

    <title>Document</title>
    <style>

    /* General Styling */
    body {
        font-family: 'Roboto', Arial, sans-serif;
        background-color: #f8f9fa; /* Light Gray */
        margin: 0;
        padding: 0;
    }

    h3 {
        color: #2c3e50; /* Dark Blue */
        font-weight: bold;
        margin-bottom: 20px;
    }

    .container {
        max-width: 1000px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin: 50px auto;
    }

    /* Navbar Styling */
   /* Navbar Styling */
.navbar-custom {
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

.nav-link {
    color: #dcdcdc;
    font-size: 1rem;
    transition: color 0.3s ease;
    margin-right: 10px;
}

.nav-link:hover {
    color: #ffffff; /* Bright white on hover */
    font-weight: bold;
    text-shadow: 0 2px 4px rgba(255, 255, 255, 0.3);
}

.btn-danger {
    border-radius: 8px;
    padding: 8px 20px;
    transition: transform 0.3s ease, background-color 0.3s ease;
}

.btn-danger:hover {
    background-color: #c0392b; /* Slightly darker red */
    transform: scale(1.1); /* Enlarge on hover */
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
    /* Alerts Styling */
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



    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 20px;
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
          <a class="nav-link" href="kategori.php"> <i class="fas fa-th-list me-2"></i>Kategori</a>
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
<h3>Produk-Detail</h3>

<div class="col-12 col-md-6 mb-5">
<form action="" method="post" enctype="multipart/form-data">
    <div>
    <label for="nama">nama</label>
    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama'];?>">
    </div>
    <div>
        <label for="kategori">kategori</label>
        <select name="kategori" id="kategori" class="form-control" required>
            <option value="<?php echo $data['kategori_id'];?>"><?php echo $data['nama_kategori'];?></option>
            <?php 
            while($datakategori = mysqli_fetch_array($querykategori)){
            ?>
                <option value="<?php echo $datakategori['id']?>"><?php echo $datakategori['nama']?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div>
        <label for="harga">Harga</label>
        <input type="number" class="form-control" value="<?php echo $data['harga'];?>" name="harga" required>
    </div>
    <div>
        <label for="currentfoto">Foto produk</label>
        <img src="image/<?php echo $data['foto'];?>" alt="" width="300px">
    </div>
    <div>
        <label for="foto">Foto</label>
        <input type="file" name="foto" id="foto" class="form-control">
    </div>
    <div>
        <label for="detail">Detail</label>
        <textarea name="detail" id="detail" rows="10" cols="10" class="form-control">
        <?php echo $data['detail'];?>
        </textarea>
    </div>
    <div>
    <label for="ukuran">Ukuran</label>
    <select name="ukuran[]" id="ukuran" class="form-control" multiple>
        <?php
        // Retrieve all available sizes
        $queryUkuran = mysqli_query($conn, "SELECT * FROM ukuran");
        while($size = mysqli_fetch_array($queryUkuran)) {
        ?>
            <option value="<?php echo $size['id']; ?>"><?php echo $size['nama']; ?></option>
        <?php } ?>
    </select>
</div>

<div>
    <label for="stok">Stok per Ukuran</label>
    <input type="text" name="stok[]" id="stok" class="form-control">
</div>


    <div>
        <label for="ketersediaan_stok">ketersediaan stok</label>
        <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
            <option value="<?php echo $data['ketersediaan_stok'];?>"><?php echo $data['ketersediaan_stok'];?></option>
            <?php
            if($data['ketersediaan_stok']=='tersedia'){
            ?>
                <option value="habis">habis</option>
            <?php
            }
            else{
                ?>                
                <option value="tersedia">tersedia</option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success" name="simpan">update</button>
        <button type="submit" class="btn btn-danger" name="hapus">Delete</button>
        <a href="produk.php" class="btn btn-warning">Kembali ke Produk</a>
    </div>
</form>
<?php
  if(isset($_POST['simpan'])){
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga = htmlspecialchars($_POST['harga']);
    $detail = htmlspecialchars($_POST['detail']);
    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);
    $ukuran = $_POST['ukuran'];  // Get selected sizes
    $stok = $_POST['stok'];      // Get stock for each size

    // Check if all required fields are filled
    if ($nama == "" || $kategori == "" || $harga == "" || empty($ukuran) || empty($stok)){
        ?>
        <div class="alert alert-warning mt-3" role="alert">
            Nama, kategori, harga, ukuran, dan stok belum terisi.
        </div>
        <?php
    } else {
        // Update produk table
        $queryupdate = mysqli_query($conn, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id=$id");

        if ($queryupdate) {
            // Loop through each selected size and update the produk_ukuran table
            foreach ($ukuran as $key => $size_id) {
                $size_stock = $stok[$key];  // Get corresponding stock for the size
                // Update or insert size stock in produk_ukuran
                $queryProdukUkuran = mysqli_query($conn, "SELECT * FROM produk_ukuran WHERE produk_id='$id' AND ukuran_id='$size_id'");
                if (mysqli_num_rows($queryProdukUkuran) > 0) {
                    // If the size already exists for the product, update it
                    mysqli_query($conn, "UPDATE produk_ukuran SET stok='$size_stock' WHERE produk_id='$id' AND ukuran_id='$size_id'");
                } else {
                    // Insert new size stock for the product
                    mysqli_query($conn, "INSERT INTO produk_ukuran (produk_id, ukuran_id, stok) VALUES ('$id', '$size_id', '$size_stock')");
                }
            }
            ?>
            <div class="alert alert-success mt-3" role="alert">
                Produk berhasil diupdate.
            </div>
            <meta http-equiv="refresh" content="1; url=produk.php" />
            <?php
        } else {
            echo mysqli_error($conn);
        }
    }
}

?>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>