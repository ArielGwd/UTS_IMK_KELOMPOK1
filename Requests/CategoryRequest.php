<?php

require_once '../config/request.php';

switch ($_GET['action'] ?? '') {
    case 'add':
        $name = $_POST['name'];

        if (empty($name)) {
            $err = "Nama kategori tidak boleh kosong.";
            header("Location: ../categories/index.php?err=$err");
            exit();
        }

        try {
            $data = $koneksi->prepare("INSERT INTO categories (name) VALUES (?)");
            $data->bind_param("s", $name);
            $data->execute();

            if (!$data) {
                $err = "Gagal menambahkan kategori: " . $koneksi->error;
                header("Location: ../categories/index.php?err=$err");
            } else {
                header("Location: ../categories/index.php");
                exit();
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;
    case 'update':
        $id = $_POST['id'];
        $name = $_POST['name'];

        if (empty($name)) {
            $err = "Nama kategori tidak boleh kosong.";
            header("Location: ../categories/index.php?err=$err");
            exit();
        }

        try {
            $data = $koneksi->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $data->bind_param("si", $name, $id);
            $data->execute();

            if (!$data) {
                $err = "Gagal mengedit kategori: " . $koneksi->error;
                header("Location: ../categories/index.php?err=$err");
            } else {
                header("Location: ../categories/index.php");
                exit();
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;
    case 'delete':
        $id = $_POST['id'];

        try {
            $data = $koneksi->prepare("DELETE FROM categories WHERE id = ?");
            $data->bind_param("i", $id);
            $data->execute();

            if (!$data) {
                $err = "Gagal menghapus kategori: " . $koneksi->error;
                header("Location: ../categories/index.php?err=$err");
            } else {
                header("Location: ../categories/index.php");
                exit();
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;
    default:
        header("Location: ../categories/index.php");
        exit();
        break;
}
