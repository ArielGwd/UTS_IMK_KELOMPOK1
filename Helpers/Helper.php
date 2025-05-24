<?php


class Helper
{
    public static function generateKdBuku($prefix = 'BK', $length = 4)
    {
        require_once '../config/request.php';
        $date = date('ymd');
        $query = "SELECT MAX(kd_buku) as max_kd_buku FROM books WHERE kd_buku LIKE '$prefix%'";
        $result = $koneksi->query($query);
        $row = $result->fetch_assoc();

        $maxKdBuku = $row['max_kd_buku'];
        if ($maxKdBuku) {
            $increment = (int)substr($maxKdBuku, -$length) + 1;
        } else {
            $increment = 1;
        }

        $kdBuku = $prefix . '-' . $date . '-' . str_pad($increment, $length, '0', STR_PAD_LEFT);
        return $kdBuku;
    }
}
