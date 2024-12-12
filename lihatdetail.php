<?php
session_start(); // Inisialisasi sesi
require "koneksi.php";

// Tangani permintaan GET untuk menampilkan detail produk
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT id, nama, foto, harga, detail, ketersediaan_stok, kategori_id FROM produk WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
    die("Produk tidak ditemukan.");
}

$stmt->close();

// Query produk terkait
$queryprodukterkait = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='" . $produk['kategori_id'] . "' AND id!='" . $produk['id'] . "' LIMIT 4");

$query_ukuran = $conn->prepare("
    SELECT u.id AS ukuran_id, u.nama AS ukuran_nama, pu.stok AS ukuran_stok
    FROM produk_ukuran pu
    JOIN ukuran u ON pu.ukuran_id = u.id
    WHERE pu.produk_id = ?
");
$query_ukuran->bind_param("i", $id_produk);
$query_ukuran->execute();
$result_ukuran = $query_ukuran->get_result();
$ukuran_list = $result_ukuran->fetch_all(MYSQLI_ASSOC);
$query_ukuran->close();

// Query produk terkait
$queryprodukterkait = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='" . $produk['kategori_id'] . "' AND id!='" . $produk['id'] . "' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Detail Produk</title>
    <style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(90deg, #f3f4f7, #fdfdfd);
    color: #333;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

.navbar {
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar .navbar-brand {
    font-weight: bold;
    color: #333;
}

.navbar .navbar-nav .nav-link {
    color: #555;
    transition: color 0.3s ease;
}

.navbar .navbar-nav .nav-link:hover {
    color: #007bff;
}

.navbar-bottom {
    position: fixed;
    bottom: 0;
    width: 100%;
    border-top: 1px solid #ddd;
}

.navbar-bottom .nav-link {
    color: #888;
    font-size: 0.85rem;
}

.navbar-bottom .nav-link i {
    font-size: 1.5rem;
}

.navbar-bottom .nav-link:hover {
    color: #007bff;
}

/* Product Content */
.product-content {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    animation: fadeIn 1s ease-in-out;
}

.image-slider img {
    width: 100%;
    max-width: 400px;
    object-fit: cover;
    animation: slideIn 1s ease-out;
    border-radius: 10px 0 0 10px;
}

.product-description {
    flex: 1;
    padding: 20px;
}

.product-description h2 {
    margin: 0 0 10px;
    font-size: 1.8rem;
    color: #222;
}

.product-description p {
    font-size: 1rem;
    line-height: 1.5;
    color: #555;
    margin-bottom: 15px;
}

.product-description ul {
    list-style: none;
    padding: 0;
}

.product-description ul li {
    margin-bottom: 10px;
    font-size: 0.95rem;
    color: #666;
}

.product-description .buttons button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-description .buttons button:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
}

.product-description .buttons button:active {
    transform: translateY(1px);
}

/* Animations */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideIn {
    0% {
        transform: translateX(-100%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Footer */
footer {
    margin-top: 20px;
    text-align: center;
    font-size: 0.85rem;
    color: #aaa;
    padding: 10px 0;
    background: #f8f9fa;
}

footer a {
    color: #007bff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><i class="fas fa-store"></i>TrenNexus</a>
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

    <div class="container">
        <div class="product-content">
            <div class="image-slider">
                <img src="image/<?php echo htmlspecialchars($produk['foto']); ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
            </div>
            <div class="product-description">
                <h2><?php echo htmlspecialchars($produk['nama']); ?></h2>
                <p id="short-description"><?php echo substr(htmlspecialchars($produk['detail']), 0, 100); ?>...</p>
                <button onclick="toggleDescription()">Lihat Deskripsi Lengkap</button>
                <p id="full-description" style="display: none;"><?php echo htmlspecialchars($produk['detail']); ?></p>
                <ul>
                    <li>Harga: Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></li>
                    <li>Ketersediaan Stok: <?php echo htmlspecialchars($produk['ketersediaan_stok']); ?></li>
                    <li>
                        <label>Ukuran:</label><br>
                        <?php foreach ($ukuran_list as $ukuran): ?>
                            <label>
                                <input type="radio" name="ukuran" value="<?php echo $ukuran['ukuran_id']; ?>" 
                                <?php echo $ukuran['ukuran_stok'] > 0 ? '' : 'disabled'; ?>>
                                <?php echo htmlspecialchars($ukuran['ukuran_nama']); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </li>
                    <li>
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" id="jumlah" name="jumlah" value="1" min="1" max="<?php echo $produk['ketersediaan_stok']; ?>">
                    </li>
                </ul>
                <div class="buttons">
                    <button onclick="tambahKeranjang(<?php echo htmlspecialchars($produk['id']); ?>)">Tambah ke Keranjang</button>
                    <button onclick="beliSekarang(<?php echo htmlspecialchars($produk['id']); ?>)">Checkout</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function tambahKeranjang(id) {
        const jumlah = document.getElementById('jumlah').value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "keranjang.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                const response = JSON.parse(xhr.responseText);
                alert(response.message);
            }
        };
        xhr.send(
            "id=" + id +
            "&nama=" + encodeURIComponent("<?php echo $produk['nama']; ?>") +
            "&harga=<?php echo $produk['harga']; ?>" +
            "&jumlah=" + jumlah
        );
    }

    function beliSekarang(id) {
        window.location.href = '/checkout.php?id=' + id;
    }

    
</script>
<div class="container-fluid py-5 warna2 ">
    <div class="container">
        <h2 class="text-center mb-5">Produk terkait</h2>
        <div class="row">
            <?php while($data = mysqli_fetch_array($queryprodukterkait)) { ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="lihatdetail.php?id=<?php echo $data['id']; ?>">
                        <img src="image/<?php echo htmlspecialchars($data['foto']); ?>" alt="<?php echo htmlspecialchars($data['nama']); ?>" class="img-fluid img-thumbnail produk-terkait-image">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
