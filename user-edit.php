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

// Handle the form submission to update the user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Query to update the user data
    $queryUpdate = mysqli_prepare($conn, "UPDATE users SET username = ?, email = ?, no_telp = ?, alamat = ?, role = ? WHERE id = ?");
    mysqli_stmt_bind_param($queryUpdate, "sssssi", $username, $email, $no_telp, $alamat, $role, $id);

    if (mysqli_stmt_execute($queryUpdate)) {
        echo '<div class="alert alert-success">User berhasil diperbarui</div>';
        echo '<meta http-equiv="refresh" content="1; url=user.php" />';
    } else {
        echo '<div class="alert alert-danger">Terjadi kesalahan saat memperbarui data user</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Container */
.container {
    margin-top: 50px;
    max-width: 900px;
}

/* Title Styling */
h2 {
    color: #333;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

/* Form Styling */
.form-control {
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

/* Textarea Styling */
textarea.form-control {
    height: 120px;
}

/* Button Styling */
.btn {
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s ease, box-shadow 0.3s ease;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 123, 255, 0.2);
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
}

.btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(108, 117, 125, 0.2);
}

/* Input Field Styles */
.form-label {
    font-size: 16px;
    font-weight: 500;
    color: #333;
}

/* Layout Adjustment for Smaller Screens */
@media (max-width: 768px) {
    .container {
        padding: 0 20px;
    }

    h2 {
        font-size: 28px;
    }

    .form-control {
        font-size: 14px;
    }

    .btn {
        padding: 10px;
        font-size: 14px;
    }
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit User</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No Telp:</label>
                        <input type="text" name="no_telp" class="form-control" value="<?= htmlspecialchars($data['no_telp']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat:</label>
                        <textarea name="alamat" class="form-control"><?= htmlspecialchars($data['alamat']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select name="role" class="form-control" required>
                            <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?= $data['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary w-100">Update</button>
                </form>
                <a href="user.php" class="btn btn-secondary w-100 mt-3">Kembali ke Daftar User</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
