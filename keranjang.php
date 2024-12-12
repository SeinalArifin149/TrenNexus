<?php
session_start(); // Memulai sesi untuk mengambil data keranjang

// Periksa apakah keranjang sudah ada di sesi
if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
    $keranjang = $_SESSION['keranjang'];
    $totalKeseluruhan = 0;
    foreach ($keranjang as $item) {
        $totalKeseluruhan += $item['total_harga'];
    }
} else {
    $keranjang = [];
    $totalKeseluruhan = 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-5">
    <h2 class="text-white">Keranjang Belanja</h2>
        <?php if (count($keranjang) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan (Rp)</th>
                        <th>Jumlah</th>
                        <th>Total Harga (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keranjang as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($item['nama']) ?></td>
                            <td>Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                            <td><?= $item['jumlah'] ?></td>
                            <td>Rp <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total Keseluruhan</strong></td>
                        <td>Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-white" >Keranjang Anda kosong.</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
