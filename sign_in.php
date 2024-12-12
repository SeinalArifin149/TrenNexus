<?php
require "koneksi.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO users (username, password, no_telp, email, alamat) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $password, $no_telp, $email, $alamat);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal: {$stmt->error}');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .container {
            margin-top: 7rem;
        }

        .text-center {
            color: #fff;
        }

        /* Form Styling */
        form {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        form label {
            font-weight: 600;
            color: #333;
        }

        form input {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        form input:focus {
            border-color: #6a11cb;
            box-shadow: 0px 0px 8px rgba(106, 17, 203, 0.3);
        }

        .btn-primary {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 20px;
            font-weight: bold;
            color: #fff;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #2575fc, #6a11cb);
            transform: scale(1.05);
        }

        p {
            color: #fff;
        }

        p a {
            color: #ffcc00;
            font-weight: 600;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 3rem;
            }

            form {
                padding: 1.5rem;
            }

            .btn-primary {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Sign Up</h2>
                <form method="POST" action="" class="p-3 border rounded">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. Telp:</label>
                        <input type="text" name="no_telp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat:</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100">Sign Up</button>
                </form>
                <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
