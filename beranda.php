<?php
session_start();
require 'koneksi.php';

// Ambil data produk dari database
$query = "SELECT id, nama, harga, ketersediaan_stok, detail, foto FROM produk";
$result = mysqli_query($conn, $query);

$products = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

if(isset($_GET['keyword'])){
    $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Toko Pakaian Online</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
/* Animasi Global */
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

/* Gaya untuk body */
body {
    background: linear-gradient(90deg, #1e3c72, #2a5298);
    font-family: 'Poppins', sans-serif;
    color: #333;
    animation: fadeIn 1s ease-in-out;
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


/* Kategori */
.highlighted-kategori {
    height: 150px;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.highlighted-kategori:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.kategori-Hoodie {
    background: linear-gradient(135deg, #4A90E2, #357ABD);
}
.kategori-baju-wanita {
    background: linear-gradient(135deg, #E91E63, #AD1457);
}
.kategori-baju-adat {
    background: linear-gradient(135deg, #FF9800, #E65100);
}
.highlighted-kategori h4 a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    animation: fadeIn 2s ease-in-out;
}

/* Produk */
.card {
    border: none;
    overflow: hidden;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.card img {
    border-radius: 15px 15px 0 0;
    transition: transform 0.3s ease;
}
.card img:hover {
    transform: scale(1.1);
}
.card-title {
    font-weight: bold;
    color: #5476B3;
}
.card-text {
    color: #666;
}

/* Navbar bawah */
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
.warna3 {
    background: linear-gradient(135deg, #4A90E2, #357ABD); /* Linear gradient dengan sudut 135 derajat */
    width: 100%; /* Memastikan elemen memenuhi lebar tampilan (viewport) */
    height: auto; /* Tinggi otomatis tergantung pada konten */
    position: relative; /* Agar animasi bisa diterapkan dengan baik */
    display: flex;
    justify-content: center;
    align-items: center;
    animation: backgroundAnim 5s ease-in-out infinite; /* Animasi latar belakang untuk memberikan efek perubahan */
    margin: 0;
}

.warna3 h3 {
    font-size: 2.5rem; /* Ukuran font untuk judul */
    font-weight: bold;
    color: white;
    animation: fadeIn 2s ease-out; /* Animasi muncul untuk judul */
}

.warna3 p {
    font-size: 1.25rem; /* Ukuran font untuk deskripsi */
    color: white;
    max-width: 800px; /* Membatasi lebar teks agar lebih mudah dibaca */
    margin: 20px auto; /* Menjaga jarak teks agar tidak terlalu rapat dengan tepi */
    animation: fadeIn 3s ease-out; /* Animasi muncul untuk teks */
}

/* Animasi untuk latar belakang */
@keyframes backgroundAnim {
    0% {
        background: linear-gradient(135deg, #4A90E2, #357ABD);
    }
    50% {
        background: linear-gradient(135deg, #357ABD, #4A90E2);
    }
    100% {
        background: linear-gradient(135deg, #4A90E2, #357ABD);
    }
}

/* Animasi untuk teks muncul */
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


    </style>
</head>
<body style="background: linear-gradient(90deg, #1e3c72, #2a5298)">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="image/logo.png"  alt="" class="src" width="50" height="50">TrenNexus</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="search-container">
            <form class="form-inline" method="get" action="list-kategori.php">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Cari produk..." aria-label="Search" required>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
            </form>
            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-info-circle fa-lg"></i> Tentang Kami</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="text-center">TrenNexus</h1>
            </div>
        </div>

    <!-- Main content -->
    <div class="container mt-5">

        <div class="container-fluid py-5 text-white">
            <div class="container">
                <h3>kategori terlaris</h3>

                <div class="row mt-5">
                    <div class="col-4 mb-3">
                        <div class="highlighted-kategori kategori-Hoodie d-flex justify-content-center align-items-center ">
                            <h4 class="text-white"><a class="no-decoration" href="list-kategori.php?kategori=Hoodie">HOODIE</a></h4>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="highlighted-kategori kategori-baju-wanita  d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="list-kategori.php?kategori=baju wanita">BAJU WANITA</a></h4>
                        </div>
                    </div> 
                    <div class="col-4 mb-3">
                        <div class="highlighted-kategori kategori-baju-adat  d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="list-kategori.php?kategori=baju adat">BAJU ADAT</a></h4>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                    <a class="btn btn-success mt-3 p-3 fs-3 " href="list-kategori.php">see more</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>TRENNEXUS</h3>
            <p class="fs-5 mt-3">Trennexus adalah gabungan dari dua kata "tren" yang merujuk tren atau model, dan "nexus" yang berarti titik penghubung atau pusat. secara keseluruhan, "TRENNEXUS" dapat diartikan sebagai pusat atau titik fokus tren dan model, menciptakan kesan bahwa tempat tersebut adalah pusat inovasi dan gaya terbaru dalam dunia fashion</p>
        </div>
     </div>

       <!-- Product Table -->
<div class="category-section container mt-5 text-white">
    <h2>Daftar Produk</h2>
    <div class="row">
        <?php if (empty($products)): ?>
            <p class="text-center">Tidak ada produk yang tersedia.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-3">
                    <div class="shadow p-3 mb-1 bg-white rounded">
                        <div class="card">
                            <img src="image/<?php echo !empty($product['foto']) ? htmlspecialchars($product['foto']) : 'default.jpg'; ?>" width="200rem" height="150rem" class="card-img-top" alt="<?php echo htmlspecialchars($product['nama'] ?? 'Unknown Product'); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['nama'] ?? 'No name'); ?></h5>
                                <p class="card-text">Rp <?php echo number_format($product['harga'] ?? 0, 0, ',', '.'); ?></p>
                                <p class="card-text">Stok: <?php echo htmlspecialchars($product['ketersediaan_stok'] ?? 'Unknown'); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($product['detail'] ?? 'No description available'); ?></p>
                                <a href="lihatdetail.php?id=<?php echo urlencode($product['id']); ?>" class="btn btn-primary">Lihat Detail</a>
                            </div>
                            <div class="position-absolute top-0 end-0 p-2">
                            <button class="btn btn-outline-danger add-to-favorite" data-id="<?= $product['id']; ?>">
                                <i class="fas fa-heart"></i> 
                            </button>

                            </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const favoriteButtons = document.querySelectorAll('.add-to-favorite');

                            favoriteButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    const productId = this.getAttribute('data-id');
                                    const icon = this.querySelector('i');

                                    // Disable button temporarily to prevent multiple clicks
                                    this.disabled = true;

                                    fetch('add_to_favorite.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: `product_id=${encodeURIComponent(productId)}`
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.status === 'success') {
                                            icon.classList.toggle('text-danger'); // Ubah warna ikon
                                            icon.classList.add('animated-heart'); // Animasi untuk ikon
                                        } else {
                                            alert(data.message || 'Gagal menambahkan ke favorit. Silakan coba lagi.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Terjadi kesalahan saat mengirim permintaan. Silakan coba lagi nanti.');
                                    })
                                    .finally(() => {
                                        // Enable button after operation
                                        this.disabled = false;
                                    });
                                });
                            });
                        });
                        </script>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

    </div>

    <!-- Navbar Bottom -->
    <nav class="navbar navbar-expand navbar-bottom navbar-light">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a class="nav-link" href="beranda.php"><i class="fas fa-home fa-lg"></i><br>Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="keranjang.php"><i class="fas fa-shopping-cart fa-lg"></i><br>Keranjang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="favorite.php"><i class="fas fa-heart fa-lg"></i><br>Favorit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pengaturan.php"><i class="fas fa-cog fa-lg"></i><br>Pengaturan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="me.php"><i class="fas fa-user fa-lg"></i><br>Me</a>
            </li>
        </ul>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
