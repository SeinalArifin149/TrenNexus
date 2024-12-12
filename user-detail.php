<?php
session_start();
require "koneksi.php";

// Validasi parameter ID
if (!isset($_GET['x']) || empty($_GET['x'])) {
    echo '<div class="alert alert-danger">ID user tidak ditemukan</div>';
    exit;
}

$id = intval($_GET['x']);

// Query untuk mengambil data user berdasarkan ID
$queryUser = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($queryUser, "i", $id);
mysqli_stmt_execute($queryUser);
$result = mysqli_stmt_get_result($queryUser);

if (mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-warning">User dengan ID ini tidak ditemukan</div>';
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Detail User</title>
    <style>
     /* Container for the detail page */
.detail-container {
    margin-top: 50px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

/* Heading Style */
.detail-container h2 {
    color: #333;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    text-transform: uppercase;
}

/* Paragraph Styling */
.detail-container p {
    font-size: 18px;
    margin-bottom: 12px;
    color: #555;
}

.detail-container p strong {
    color: #333;
}

/* Button Style */
.btn-back {
    display: inline-block;
    background-color: #007bff;
    border: none;
    color: #fff;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 16px;
    text-decoration: none;
    margin-top: 20px;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-back:hover {
    background-color: #0056b3;
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.btn-back:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Responsive Design for smaller screens */
@media (max-width: 768px) {
    .detail-container {
        padding: 20px;
    }

    .detail-container h2 {
        font-size: 28px;
    }

    .detail-container p {
        font-size: 16px;
    }

    .btn-back {
        padding: 10px 20px;
        font-size: 14px;
    }
}

    </style>
</head>
<body>
<div class="container">
    <div class="detail-container">
        <h2>Detail User</h2>
        <p><strong>Username:</strong> <?= htmlspecialchars($data['username']); ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($data['password']); ?></p>
        <p><strong>No Telp:</strong> <?= htmlspecialchars($data['no_telp']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($data['email']); ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']); ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($data['role']); ?></p>
        <a href="user.php" class="btn-back">Kembali</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
