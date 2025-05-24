<?php

include_once '../config/request.php';


switch ($_GET['action'] ?? '') {
    case 'add':
        $student_id = $_POST['student_id'];
        $officer_id = $_POST['officer_id'];
        $kd_buku = $_POST['kd_buku'];
        $jumlah_peminjaman = $_POST['jumlah_peminjaman'];
        $status = 'dipinjam';
        $tanggal_pinjam = date('Y-m-d H:i:s');

        if (empty($student_id) || empty($officer_id) || empty($kd_buku) || empty($jumlah_peminjaman)) {
            $_SESSION['message'] = "Semua kolom harus diisi.";
            header("Location: ../peminjaman/index.php");
            break;
        }

        $stmt = $koneksi->prepare("SELECT jumlah FROM books WHERE kd_buku = ?");
        $stmt->bind_param("s", $kd_buku);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = $result->fetch_object();

        if (!$book || $book->jumlah <= 0) {
            $_SESSION['message'] = "Jumlah buku tidak mencukupi atau buku tidak ditemukan.";
            header("Location: ../peminjaman/index.php");
            break;
        }

        try {
            $stmt = $koneksi->prepare("INSERT INTO peminjaman (student_id, officer_id, kd_buku, jumlah_peminjaman, status, tanggal_pinjam) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissss", $student_id, $officer_id, $kd_buku, $jumlah_peminjaman, $status, $tanggal_pinjam);
            $stmt->execute();

            $stmt = $koneksi->prepare("SELECT jumlah FROM books WHERE kd_buku = ?");
            $stmt->bind_param("s", $kd_buku);
            $stmt->execute();
            $result = $stmt->get_result();
            $book = $result->fetch_object();

            $new_quantity = $book->jumlah - $jumlah_peminjaman;

            if ($new_quantity < 0) {
                $_SESSION['message'] = "Jumlah buku tidak mencukupi.";
                header("Location: ../peminjaman/index.php");
                break;
            }

            $stmt = $koneksi->prepare("UPDATE books SET jumlah = ? WHERE kd_buku = ?");
            $stmt->bind_param("is", $new_quantity, $kd_buku);
            $stmt->execute();

            header("Location: ../peminjaman/index.php");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;

    case 'update':
        $id = $_POST['id'];
        $student_id = $_POST['student_id'];
        $officer_id = $_POST['officer_id'];
        $kd_buku = $_POST['kd_buku'];
        $jumlah_peminjaman = $_POST['jumlah_peminjaman'];
        $status = $_POST['status'];

        if (empty($student_id) || empty($officer_id) || empty($kd_buku) || empty($jumlah_peminjaman)) {
            $_SESSION['message'] = "Semua kolom harus diisi.";
            header("Location: ../peminjaman/index.php?page=edit&id=$id");
            break;
        }

        try {

            $stmt = $koneksi->prepare("UPDATE peminjaman SET student_id = ?, officer_id = ?, kd_buku = ?, jumlah_peminjaman = ?, status = ? WHERE id = ?");
            $stmt->bind_param("iisssi", $student_id, $officer_id, $kd_buku, $jumlah_peminjaman, $status, $id);
            $stmt->execute();

            if ($status === 'dikembalikan') {
                $stmt = $koneksi->prepare("SELECT jumlah FROM books WHERE kd_buku = ?");
                $stmt->bind_param("s", $kd_buku);
                $stmt->execute();
                $result = $stmt->get_result();
                $book = $result->fetch_object();

                if ($book) {
                    $new_quantity = $book->jumlah + $jumlah_peminjaman;
                    $stmt = $koneksi->prepare("UPDATE books SET jumlah = ? WHERE kd_buku = ?");
                    $stmt->bind_param("is", $new_quantity, $kd_buku);
                    $stmt->execute();
                }
            }

            header("Location: ../peminjaman/index.php");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;
    case 'delete':
        $id = $_POST['id'];

        if (empty($id)) {
            $_SESSION['message'] = "ID peminjaman tidak ditemukan.";
            header("Location: ../peminjaman/index.php?page=delete");
            break;
        }

        try {
            $stmt = $koneksi->prepare("SELECT kd_buku, jumlah_peminjaman, status FROM peminjaman WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $peminjaman = $result->fetch_object();

            if ($peminjaman && $peminjaman->status === 'dipinjam') {
                $kd_buku = $peminjaman->kd_buku;
                $jumlah_peminjaman = $peminjaman->jumlah_peminjaman;

                $stmt = $koneksi->prepare("SELECT jumlah FROM books WHERE kd_buku = ?");
                $stmt->bind_param("s", $kd_buku);
                $stmt->execute();
                $result = $stmt->get_result();
                $book = $result->fetch_object();

                if ($book) {
                    $new_quantity = $book->jumlah + $jumlah_peminjaman;
                    $stmt = $koneksi->prepare("UPDATE books SET jumlah = ? WHERE kd_buku = ?");
                    $stmt->bind_param("is", $new_quantity, $kd_buku);
                    $stmt->execute();
                }
            }

            $stmt = $koneksi->prepare("DELETE FROM peminjaman WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            header("Location: ../peminjaman/index.php");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
        break;
    default:
        echo "404 Not Found";
        break;
}
