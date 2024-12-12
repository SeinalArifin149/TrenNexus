<?php
session_start();
require 'koneksi.php';

// Ambil produk favorit dari session
$fav_products = [];
if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['favorites']), '?'));
    $stmt = $conn->prepare("SELECT id, nama, harga, ketersediaan_stok, detail, foto FROM produk WHERE id IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($_SESSION['favorites'])), ...$_SESSION['favorites']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $fav_products[] = $row;
    }
}

// Hapus produk dari favorit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_favorites'])) {
    $selected_ids = $_POST['product_ids'] ?? [];
    $_SESSION['favorites'] = array_diff($_SESSION['favorites'], $selected_ids);
    header("Location: favorite.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<style>
/* Navbar bawah */
.navbar-bottom {
    background: #fff;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 1030; /* Memastikan navbar berada di atas elemen lainnya */
    box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1); /* Memberikan sedikit bayangan untuk estetika */
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
.btn-hapus-favorit {
    position: fixed;
    bottom: 60px; /* Memberikan jarak dari navbar bawah */
    right: 20px;  /* Memberikan jarak dari tepi kanan layar */
    z-index: 1050; /* Memastikan tombol berada di atas elemen lainnya */
}

</style>
<body style="background: linear-gradient(90deg, #1e3c72, #2a5298)">
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="image/logobaru.png" alt="" class="src" width="50" height="50">TrenNexus</a>
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
    <div class="container mt-4">
        <h1 class="text-white">Produk Favorit</h1>
        <form method="post">
            <div class="row">
                <?php foreach ($fav_products as $product): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="image/<?= $product['foto']; ?>" class="card-img-top" alt="<?= $product['nama']; ?>">
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" name="product_ids[]" value="<?= $product['id']; ?>" class="form-check-input">
                                    <label class="form-check-label"> <?= $product['nama']; ?> </label>
                                </div>
                                <p class="card-text mt-2"><?= $product['detail']; ?></p>
                                <p class="text-primary fw-bold">Rp <?= number_format($product['harga'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (empty($fav_products)): ?>
                <p class="text-center text-white">Tidak ada produk favorit yang tersedia.</p>
            <?php else: ?>
                <form method="post">
            <button type="submit" name="delete_favorites" class="btn btn-danger btn-lg">Hapus favorite</button>
        </form>
            <?php endif; ?>
    </div>

   <!-- Navbar Bottom -->
<nav class="navbar navbar-expand navbar-bottom navbar-light bg-white">
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
