<?php
session_start();
require "koneksi.php";

// Validasi parameter ID
if (!isset($_GET['x']) || empty($_GET['x'])) {
    echo '<div class="alert alert-danger">ID user tidak ditemukan</div>';
    exit;
}

$id = intval($_GET['x']);

// Query untuk menghapus user berdasarkan ID
$queryDelete = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
mysqli_stmt_bind_param($queryDelete, "i", $id);
$querySukses = mysqli_stmt_execute($queryDelete);

if ($querySukses) {
    echo '<div class="alert alert-success">User berhasil dihapus</div>';
    echo '<meta http-equiv="refresh" content="1; url=user.php" />';
} else {
    echo '<div class="alert alert-danger">Terjadi kesalahan saat menghapus user</div>';
}
?>
