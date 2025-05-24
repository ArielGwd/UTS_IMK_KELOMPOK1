<?php
session_start();

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'petugas'])) {
    header('Location: ../auth/login/');
    exit();
}

require_once '../config/request.php';

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
                        <a href="../peminjaman/" class="inline-flex items-center px-10 py-3 rounded-lg group hover:text-violet-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400 group-hover:text-violet-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6H5m2 3H5m2 3H5m2 3H5m2 3H5m11-1a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2M7 3h11a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm8 7a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                            </svg>
                            Peminjaman
                        </a>
                    </li>
                    <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                        <li>
                            <a href="../officers/" class="inline-flex items-center px-10 py-3 rounded-lg group hover:text-violet-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400 group-hover:text-violet-900" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z" />
                                </svg>
                                Petugas
                            </a>
                        </li>
                    <?php } ?>
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
                        <a href="../categories/" class=" inline-flex items-center px-10 py-3 rounded-lg bg-violet-700 w-full dark:bg-violet-600 text-white">
                            <svg class="w-5 h-5 mr-2 text-gray-100 dark:text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11H4m15.5 5a.5.5 0 0 0 .5-.5V8a1 1 0 0 0-1-1h-3.75a1 1 0 0 1-.829-.44l-1.436-2.12a1 1 0 0 0-.828-.44H8a1 1 0 0 0-1 1M4 9v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-3.75a1 1 0 0 1-.829-.44L9.985 8.44A1 1 0 0 0 9.157 8H5a1 1 0 0 0-1 1Z" />
                            </svg>
                            Kategori
                        </a>
                    </li>
                </ul>

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
            <section>
                <div id="add-modal-peminjaman" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <form class="relative bg-white bookForm rounded-lg shadow-sm dark:bg-gray-700" action="../Requests/PeminjamanRequest.php?action=add" method="POST">
                            <?php
                            include '../peminjaman/add.php';
                            ?>
                        </form>
                    </div>
                </div>
            </section>

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