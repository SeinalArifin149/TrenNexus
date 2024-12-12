<?php
require "koneksi.php";

$querykategori = mysqli_query($conn, "SELECT * FROM kategori");

if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$keyword%'");
}

else if (isset($_GET['kategori'])) {
    $kategori = mysqli_real_escape_string($conn, $_GET['kategori']);
    $queryGetKategoriId = mysqli_query($conn, "SELECT id FROM kategori WHERE nama='$kategori'");
    
    if ($queryGetKategoriId && mysqli_num_rows($queryGetKategoriId) > 0) {
        $kategoriid = mysqli_fetch_array($queryGetKategoriId);
        $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='{$kategoriid['id']}'");
    } else {
        echo "<script>alert('Kategori \"$kategori\" tidak ditemukan!');</script>";
        $queryproduk = false; // Tidak ada produk untuk kategori ini
    }
}
// Handle produk default
else {
    $queryproduk = mysqli_query($conn, "SELECT * FROM produk");
}

$countdata = $queryproduk ? mysqli_num_rows($queryproduk) : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Toko Online | Produk</title>
    <style>
        /* Global Styles */
        @keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Navbar */
.navbar {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: bold;
    color: #5476B3 !important;
    display: flex;
    align-items: center;
}

.navbar .search-container input[type="search"] {
    width: 250px;
    border: 2px solid #5476B3;
    padding: 5px 15px;
    transition: all 0.3s ease;
}

.navbar .search-container input[type="search"]:focus {
    outline: none;
    box-shadow: 0 0 10px rgba(84, 118, 179, 0.5);
}

.navbar .search-container button {
    font-size: 1rem;
    font-weight: bold;
    transition: background 0.3s, transform 0.3s;
}

.navbar .search-container button:hover {
    background: #28a745;
    transform: scale(1.1);
    color: white;
}

.nav-link {
    font-size: 1rem;
    color: #6c757d;
    transition: color 0.3s ease;
    text-decoration: none;
}

.nav-link:hover {
    color: #5476B3;
}

.nav-link i {
    margin-right: 5px;
}


/* Gaya untuk body */
body {
    background: linear-gradient(90deg, #1e3c72, #2a5298);
    font-family: 'Poppins', sans-serif;
    color: #333;
    animation: fadeIn 1s ease-in-out;
}

/* Categories List */
.list-group-item {
    border: none;
    background: #f8f9fa;
    transition: background 0.3s, transform 0.3s;
}

.list-group-item:hover {
    background: #e9ecef;
    transform: translateX(10px);
}

/* Product Card */
.card {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.text-harga {
    font-size: 1.1rem;
    color: #28a745;
    font-weight: bold;
}

.image-box img {
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.image-box:hover img {
    transform: scale(1.1);
}
.navbar-bottom {
    background: #fff;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
}
.navbar-bottom .nav-item .nav-link {
    color: #666;
    transition: color 0.3s ease;
}
.navbar-bottom .nav-item .nav-link:hover {
    color: #5476B3;
}
.navbar-bottom .nav-item .nav-link i {
    transition: transform 0.3s ease;
}
.navbar-bottom .nav-item .nav-link:hover i {
    transform: scale(1.2);
}

/* Animasi untuk produk */
@keyframes productPopIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.card {
    animation: productPopIn 0.5s ease-in-out;
}
.banner {
    height: 80vh; /* Menentukan tinggi banner 80% dari tampilan layar */
    background: url('image/bumiku.jpg') no-repeat center center; /* Gambar sebagai latar belakang, dipusatkan */
    background-size: cover; /* Agar gambar menutupi seluruh area banner */
    position: relative; /* Agar kita bisa menambahkan overlay di atas gambar */
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.3); /* Memberikan efek bayangan di dalam banner */
    overflow: hidden; /* Menghindari gambar keluar dari batas banner */
}

.banner h1 {
    font-size: 3rem; /* Ukuran font judul */
    font-weight: bold;
    text-transform: uppercase; /* Menjadikan teks huruf kapital */
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6); /* Memberikan efek bayangan pada teks untuk keterbacaan */
    animation: fadeInDown 1s ease-out; /* Menambahkan animasi teks muncul */
}

/* Efek overlay untuk memberi kontras */
.banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4); /* Overlay hitam dengan transparansi */
    z-index: 1; /* Agar overlay berada di atas gambar tapi di bawah teks */
}

/* Animasi untuk banner masuk */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.no-decoration{
    text-decoration: none;
    color: white;

}

.search-container {
    display: flex;
    align-items: center;
    gap: 10px; /* Menambahkan jarak antara input dan tombol */
}

.search-container input {
    flex-grow: 1; /* Input akan melebar secara proporsional */
}

    </style>
</head>
<body style="background: linear-gradient(90deg, #1e3c72, #2a5298)">
    <!-- Navbar -->
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><i class="fas fa-store"></i>TrenNexus</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <div class="search-container">
        <form class="d-flex" method="get" action="list-kategori.php">
            <input class="form-control me-2" type="search" name="keyword" placeholder="Cari produk..." aria-label="Search" required>
            <button class="btn btn-outline-success" type="submit">Cari</button>
        </form>
        </div>
            <ul class="navbar-nav ms-auto"> <!-- Gunakan ms-auto agar menu di kanan -->
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-info-circle fa-lg"></i> Tentang Kami</a>
            </li>
        </ul>
        </div>
    </nav>


    <!-- Banner -->
    <div class="container-fluid banner d-flex align-items-center" style="animation: fadeInDown 1s;">
    <div class="container">
        <h1 class="text-white text-center">Produk</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Kategori -->
        <div class="col-lg-3 mb-5" style="animation: fadeInUp 1s;">
            <h3>Kategori</h3>
            <ul class="list-group no-decoration">
                <?php while ($kategori = mysqli_fetch_array($querykategori)) { ?>
                    <a href="list-kategori.php?kategori=<?php echo urlencode($kategori['nama']); ?>">
                        <li class="list-group-item"><?php echo htmlspecialchars($kategori['nama']); ?></li>
                    </a>
                <?php } ?>
            </ul>
        </div>

        <!-- Produk -->
        <div class="col-lg-9">
            <h3 class="text-center mb-3">Produk</h3>
            <div class="row">
                <?php
                if ($countdata < 1) {
                    echo '<h4 class="text-center my-5">Produk yang Anda cari tidak tersedia</h4>';
                } else {
                    while ($produk = mysqli_fetch_array($queryproduk)) { ?>
                        <div class="col-md-4 mb-4" style="animation: fadeInUp 1s;">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?php echo htmlspecialchars($produk['foto']); ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($produk['nama']); ?></h5>
                                <p class="card-text text-truncate"><?php echo htmlspecialchars($produk['detail']); ?></p>
                                <p class="card-text text-harga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                                <a href="lihatdetail.php?id=<?php echo urlencode($produk['id']); ?>" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</div>

    <!-- Footer -->
    <nav class="navbar navbar-expand navbar-bottom navbar-light">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a class="nav-link" href="beranda.php"><i class="fas fa-home fa-lg"></i><br>Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="keranjang.php"><i class="fas fa-shopping-cart fa-lg"></i><br>Keranjang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="favorit.php"><i class="fas fa-heart fa-lg"></i><br>Favorit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pengaturan.php"><i class="fas fa-cog fa-lg"></i><br>Pengaturan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="me.php"><i class="fas fa-user fa-lg"></i><br>Me</a>
            </li>
        </ul>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>
