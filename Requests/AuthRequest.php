<?php

session_start();
require_once '../config/request.php';

switch ($_GET['action'] ?? '') {
    case 'login':

        if (isset($_SESSION['user'])) {
            header('Location: ../../index.php');
            exit();
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Username dan password tidak boleh kosong.";
            header("Location: ../auth/login/");
            exit();
        }

        try {
            $stmt = $koneksi->prepare("SELECT users.*, officers.*, students.*  
                                       FROM users 
                                       LEFT JOIN officers ON users.id = officers.user_id 
                                       LEFT JOIN students ON users.id = students.user_id 
                                       WHERE users.username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = $user;

                    $_SESSION['success'] = "Login berhasil.";
                    header("Location: ../index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Password salah.";
                    header("Location: ../auth/login/");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Username tidak ditemukan.";
                header("Location: ../auth/login/");
                exit();
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;
    case 'logout':
        session_unset();
        session_destroy();
        $_SESSION['success'] = "Anda telah logout.";
        header("Location: ../auth/login/");
        exit();

        break;
    default:
        // Handle default case
        break;
}
