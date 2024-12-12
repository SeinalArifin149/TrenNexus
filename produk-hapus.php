<?php
require "koneksi.php";

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    // Hapus produk berdasarkan ID
    $query = mysqli_query($conn, "DELETE FROM produk WHERE id = '$id'");

    if ($query) {
        echo '<script>alert("Produk berhasil dihapus."); window.location.href = "produk.php";</script>';
    } else {
        echo '<script>alert("Gagal menghapus produk."); window.location.href = "produk.php";</script>';
    }
} else {
    header("Location: produk.php");
    exit;
}
?>
