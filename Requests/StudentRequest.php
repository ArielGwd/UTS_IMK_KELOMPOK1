<?php

require_once '../config/request.php';


switch ($_GET['action'] ?? '') {
    case 'add':
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = 'siswa';

        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];

        if (empty($username) || empty($password) || empty($confirm_password)) {
            header("Location: ../students/index.php");
            break;
        }

        if (empty($nama) || empty($kelas)) {
            echo "Nama dan kelas tidak boleh kosong.";
            break;
        }

        if ($password !== $confirm_password) {
            echo "Password tidak sama.";
            break;
        }

        // Check if username already exists
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "Username sudah ada.";
            break;
        }

        try {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $koneksi->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);
            $stmt->execute();

            $user_id = $stmt->insert_id;

            $stmt = $koneksi->prepare("INSERT INTO students (user_id, nama_siswa, kelas) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $nama, $kelas);
            $stmt->execute();

            header("Location: ../students/index.php");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;

    case 'update':
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];

        if (empty($username)) {
            header("Location: ../students/index.php");
            break;
        }

        if (empty($nama) || empty($kelas)) {
            echo "Nama dan kelas tidak boleh kosong.";
            break;
        }

        if ($password !== $confirm_password) {
            echo "Password tidak sama.";
            break;
        }

        try {
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            } else {
                $stmt = $koneksi->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $hashed_password = $row['password'];
                } else {
                    echo "User not found.";
                    break;
                }
            }

            $stmt = $koneksi->prepare("UPDATE students SET nama_siswa = ?, kelas = ? WHERE user_id = ?");
            $stmt->bind_param("ssi", $nama, $kelas, $user_id);
            $stmt->execute();

            $stmt = $koneksi->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssi", $username, $hashed_password, $user_id);
            $stmt->execute();

            header("Location: ../students/index.php");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;
    case 'delete':
        $id = $_POST['user_id'];

        if (empty($id)) {
            header("Location: ../students/index.php");
            break;
        }

        try {
            $stmt = $koneksi->prepare("DELETE FROM students WHERE user_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $koneksi->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            header("Location: ../students/index.php");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;

    default:
        header("Location: ../students/index.php");
        break;
}
