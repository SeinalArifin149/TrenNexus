<?php
session_start();
require "koneksi.php";



if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        echo "<script>console.log('Role: {$user['role']}');</script>";

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 

            // Tampilkan pesan berdasarkan role
            if (strtolower($user['role']) === 'admin') {
                echo "<script>
                    alert('Login berhasil, Hay Admin {$user['username']}!');
                    window.location.href = 'index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Login berhasil, Hay {$user['username']}!');
                    window.location.href = 'beranda.php';
                </script>";
            }            
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        /* Responsive Adjustments */
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
                <h2 class="text-center">Login</h2>
                <form method="POST" action="" class="p-3 border rounded">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3">Belum punya akun? <a href="sign_in.php">Sign Up</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
