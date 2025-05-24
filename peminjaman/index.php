<?php
include '../config/request.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login/');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library - Aplikasi Pencatatan Peminjaman Buku</title>
    <link rel="icon" href="../assets/img/logo-unsia.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <header class="antialiased mx-auto px-4 lg:px-12 max-w-screen-xl -mb-4 ">
        <div class="bg-white border-gray-200 px-4 lg:px-12 py-3.5 dark:bg-gray-800 rounded-lg shadow-md ">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl text-violet-700 font-bold flex-1">
                    <a href="../">E-Library</a>
                </h1>

                <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="cursor-pointer flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-indigo-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-indigo-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                    <?= isset($_SESSION['user']['role']) ? ($_SESSION['user']['role'] == 'siswa' ? ucfirst($_SESSION['user']['nama_siswa']) : ucfirst($_SESSION['user']['nama'])) : '' ?>
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                        <li>
                            <p class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <?= ucfirst($_SESSION['user']['role']) ?>
                            </p>
                        </li>
                    </ul>
                    <div class="py-1">
                        <a href="../Requests/AuthRequest.php?action=logout" class="block px-4 py-2 text-sm text-red-700 hover:bg-red-100 dark:hover:bg-red-600 dark:text-red-200 dark:hover:text-white">
                            Sign out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION['message'])) { ?>
            <div id="toast-danger" class="flex items-center toast-danger w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ms-3 text-sm font-normal"><?= $_SESSION['message'] ?>.</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        <?php unset($_SESSION['message']);
        } ?>

        <div class="md:flex gap-6 py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-12">
            <aside>
                <ul class="flex-column space-y space-y-4 text-sm font-medium p-6 bg-white rounded-lg text-gray-500 dark:text-gray-400 md:me-2 mb-4 md:mb-0">
                    <li>
                        <a href="../" class="inline-flex items-center px-10 py-3 rounded-lg group hover:text-violet-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400 group-hover:text-violet-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="../peminjaman/" class=" inline-flex items-center px-10 py-3 rounded-lg bg-violet-700 w-full dark:bg-violet-600 text-white">
                            <svg class="w-5 h-5 mr-2 text-gray-100 dark:text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6H5m2 3H5m2 3H5m2 3H5m2 3H5m11-1a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2M7 3h11a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm8 7a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                            </svg>
                            Peminjaman
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') { ?>
                        <li>
                            <a href="../officers/" class="inline-flex items-center px-10 py-3 rounded-lg group hover:text-violet-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400 group-hover:text-violet-900" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z" />
                                </svg>
                                Petugas
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'petugas') { ?>
                        <li>
                            <a href="../students/" class="inline-flex items-center px-10 py-3 rounded-lg group hover:text-violet-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400 group-hover:text-violet-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.6144 7.19994c.3479.48981.5999 1.15357.5999 1.80006 0 1.6569-1.3432 3-3 3-1.6569 0-3.00004-1.3431-3.00004-3 0-.67539.22319-1.29865.59983-1.80006M6.21426 6v4m0-4 6.00004-3 6 3-6 2-2.40021-.80006M6.21426 6l3.59983 1.19994M6.21426 19.8013v-2.1525c0-1.6825 1.27251-3.3075 2.95093-3.6488l3.04911 2.9345 3-2.9441c1.7026.3193 3 1.9596 3 3.6584v2.1525c0 .6312-.5373 1.1429-1.2 1.1429H7.41426c-.66274 0-1.2-.5117-1.2-1.1429Z" />
                                </svg>
                                Siswa
                            </a>
                        </li>
                        <li>
                            <a href="../books/" class="inline-flex items-center px-10 py-3 rounded-lg group hover:text-violet-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400 group-hover:text-violet-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4" />
                                </svg>
                                Buku
                            </a>
                        </li>

                        <li>
                            <a href="../categories/" class="inline-flex items-center px-10 py-3 rounded-lg group hover:text-violet-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400 group-hover:text-violet-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11H4m15.5 5a.5.5 0 0 0 .5-.5V8a1 1 0 0 0-1-1h-3.75a1 1 0 0 1-.829-.44l-1.436-2.12a1 1 0 0 0-.828-.44H8a1 1 0 0 0-1 1M4 9v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-3.75a1 1 0 0 1-.829-.44L9.985 8.44A1 1 0 0 0 9.157 8H5a1 1 0 0 0-1 1Z" />
                                </svg>
                                Kategori
                            </a>
                        </li>
                    <?php } ?>

                </ul>

                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'petugas') { ?>
                    <ul class="mt-6">
                        <li>
                            <button data-modal-target="add-modal-peminjaman" data-modal-toggle="add-modal-peminjaman" type="button" class="inline-flex items-center cursor-pointer text-center px-6 py-3 text-white bg-green-600 rounded-lg w-full hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
                                <svg class="w-4 h-4 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1z" />
                                </svg>
                                Tambah Peminjaman
                            </button>
                        </li>
                    </ul>
                <?php } ?>

            </aside>

            <div class="w-full ini">
                <?php
                $page = $_GET['page'] ?? 'main';

                $filePath = $page . '.php';

                if (file_exists($filePath)) {
                    include($filePath);
                } else {
                    echo "<p>Halaman tidak ditemukan.</p>";
                }
                ?>
            </div>

            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'petugas') { ?>
                <section>
                    <div id="add-modal-peminjaman" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <form class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700" id="addBookForm" action="../Requests/PeminjamanRequest.php?action=add" method="POST">
                                <!-- tambah buku -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Tambah Data Peminjaman Buku
                                    </h3>
                                    <button type="button" class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-modal-peminjaman">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <?php
                                    if (isset($_GET['err'])) { ?>
                                        <div class="flex mb-3 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                            <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                            </svg>
                                            <span class="sr-only">Danger</span>
                                            <div>
                                                <span class="font-medium">Pastikan bahwa persyaratan ini terpenuhi:</span>
                                                <ul class="mt-1.5 list-disc list-inside">
                                                    <li><?php echo htmlspecialchars($_GET['err']); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <?php $students = $koneksi->query("SELECT * FROM students");
                                        if ($students && $students->num_rows > 0) { ?>
                                            <div>
                                                <label for="student" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Siswa <span class="text-red-400">*</span></label>
                                                <select id="student" name="student_id" required class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                                    <?php while ($student = $students->fetch_object()) { ?>
                                                        <option value="<?= htmlspecialchars($student->id) ?>"><?= htmlspecialchars($student->nama_siswa) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php } ?>

                                        <?php $officers = $koneksi->query("SELECT * FROM officers");
                                        if ($officers && $officers->num_rows > 0) { ?>
                                            <div>
                                                <label for="officer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Petugas <span class="text-red-400">*</span></label>
                                                <select id="officer" name="officer_id" required class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                                    <?php while ($officer = $officers->fetch_object()) { ?>
                                                        <option value="<?= htmlspecialchars($officer->id) ?>"><?= htmlspecialchars($officer->nama) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php } ?>

                                        <?php $books = $koneksi->query("SELECT * FROM books");
                                        if ($books && $books->num_rows > 0) { ?>
                                            <div>
                                                <label for="books" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buku <span class="text-red-400">*</span></label>
                                                <select id="books" name="kd_buku" required class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                                    <?php while ($book = $books->fetch_object()) { ?>
                                                        <option value="<?= htmlspecialchars($book->kd_buku) ?>"><?= htmlspecialchars($book->title) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php } ?>

                                        <div>
                                            <label for="jumlah_peminjaman" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Peminjaman <span class="text-red-400">*</span></label>
                                            <input type="number" name="jumlah_peminjaman" id="jumlah_peminjaman" min="0" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Jumlah Peminjaman" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" id="submitBtn" class="btn-loading-submit flex items-center justify-center cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        <svg id="spinner" aria-hidden="true" role="status" class="hidden w-4 h-4 mr-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                                        </svg>
                                        <span class="btn-text text-white" id="btnText">Tambah</span>
                                    </button>
                                    <button data-modal-hide="add-modal-peminjaman" type="button" class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-violet-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            <?php } ?>


        </div>
    </main>

    <?php include '../layout/footer.php'; ?>

    <script src="../assets/js/static.js"></script>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="../node_modules/simple-datatables/dist/umd/simple-datatables.js"></script>
    <script>
        if (document.getElementById("pagination-table") && typeof simpleDatatables.DataTable !== "undefined") {
            const dataTable = new simpleDatatables.DataTable("#pagination-table", {
                paging: true,
                perPage: 5,
                perPageSelect: [5, 10, 15, 20, 25],
                sortable: false,

                labels: {
                    placeholder: "Pencarian...",
                    perPage: "data per halaman",
                    noRows: "Tidak ada data",
                    noResults: "Tidak ada hasil ditemukan",
                    info: "{start} - {end} dari {rows} data",
                },
            });
        }
    </script>
</body>

</html>