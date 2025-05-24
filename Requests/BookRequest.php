<?php

require_once '../config/request.php';

switch ($_GET['action'] ?? '') {
    case 'add':
        $kd_buku = $_POST['kd_buku'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year_published = $_POST['year_published'];
        $jumlah = $_POST['jumlah'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];

        if (empty($kd_buku) || empty($title) || empty($author) || empty($year_published)) {
            header("Location: ../books/index.php");
            break;
        }

        try {
            $check = $koneksi->prepare("SELECT kd_buku FROM books WHERE kd_buku = ?");
            $check->bind_param("s", $kd_buku);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                echo "Duplicate entry for kd_buku '$kd_buku'. <script>window.location.href='../books/index.php';</script>";
            } else {
                $data = $koneksi->prepare("INSERT INTO books (kd_buku, title, author, year_published, jumlah, category_id, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $data->bind_param("sssssss", $kd_buku, $title, $author, $year_published, $jumlah, $category_id, $description);
                $data->execute();

                if (!$data) {
                    die("Query Error: " . $koneksi->errno . " - " . $koneksi->error);
                } else {
                    header("Location: ../books/index.php");
                    exit();
                }
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;

    case 'update':
        $kd_buku = $_POST['kd_buku'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year_published = $_POST['year_published'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $jumlah = $_POST['jumlah'];

        if (empty($kd_buku) || empty($title) || empty($author) || empty($year_published) || empty($category_id)) {
            header("Location: ../books/index.php");
            exit();
        }

        try {
            $data = $koneksi->prepare("UPDATE books SET title=?, author=?, year_published=?, category_id=?, description=?, jumlah=? WHERE kd_buku=?");
            $data->bind_param("sssssss", $title, $author, $year_published, $category_id, $description, $jumlah, $kd_buku);

            $data->execute();

            if (!$data) {
                die("Query Error: " . $koneksi->errno . " - " . $koneksi->error);
            } else {
                header("Location: ../books/index.php");
                exit();
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;

    case 'delete':
        $kd_buku = $_POST['kd_buku'];

        try {
            $data = $koneksi->prepare("DELETE FROM books WHERE kd_buku=?");
            $data->bind_param("s", $kd_buku);
            $data->execute();

            if (!$data) {
                die("Query Error: " . $koneksi->errno . " - " . $koneksi->error);
            } else {
                header("Location: ../books/index.php");
                exit();
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;

    default:
        echo "404 Error.";
        break;
}
