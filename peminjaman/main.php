<div class="background2 p-6 md:ml-2 bg-white text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full rounded-lg">
    <div class="flex items-center">
        <div class=" flex-1">
            <h3 class="text-lg font-bold text-xl text-violet-800 dark:text-violet-600">History Peminjaman Buku</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Berikut adalah data peminjaman buku yang terdaftar</p>
        </div>
    </div>
</div>

<div class="relative overflow-x-hidden pt-2 pl-2 mt-6">
    <?php
    if (isset($_GET['message'])) {
        echo htmlspecialchars($_GET['message']);
    } ?>
    <table id="pagination-table" class="bg-white w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-lg">
        <thead>
            <tr>

                <th scope="col" class="px-6 py-3">
                    Nama Siswa
                </th>
                <th scope="col" class="px-6 py-3">
                    Judul Buku
                </th>
                <th scope="col" class="px-6 py-3">
                    Jumlah Peminjaman
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Petugas
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'petugas') { ?>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                <?php } ?>

            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['username'])) {
                $username = htmlspecialchars($_GET['username']);
                $query = "SELECT peminjaman.*, officers.id AS officer_id, officers.nama AS officer_name, 
                        students.id AS student_id, students.nama_siswa AS student_name, 
                        books.kd_buku, books.title AS book_title
                        FROM peminjaman 
                        INNER JOIN officers ON peminjaman.officer_id = officers.id 
                        INNER JOIN students ON peminjaman.student_id = students.id 
                        INNER JOIN books ON peminjaman.kd_buku = books.kd_buku 
                        WHERE students.username = '$username'
                        ORDER BY peminjaman.id DESC";
            } elseif (isset($_SESSION['user']['id']) && isset($_SESSION['user']['role'])) {
                $student_id = intval($_SESSION['user']['id']);
                $query = "SELECT peminjaman.*, officers.id AS officer_id, officers.nama AS officer_name, 
                        students.id AS student_id, students.nama_siswa AS student_name, 
                        books.kd_buku, books.title AS book_title
                        FROM peminjaman 
                        INNER JOIN officers ON peminjaman.officer_id = officers.id 
                        INNER JOIN students ON peminjaman.student_id = students.id 
                        INNER JOIN books ON peminjaman.kd_buku = books.kd_buku 
                        WHERE students.id = $student_id
                        ORDER BY peminjaman.id DESC";
            } else {
                $query = "SELECT peminjaman.*, officers.id AS officer_id, officers.nama AS officer_name, 
                        students.id AS student_id, students.nama_siswa AS student_name, 
                        books.kd_buku, books.title AS book_title
                        FROM peminjaman 
                        INNER JOIN officers ON peminjaman.officer_id = officers.id 
                        INNER JOIN students ON peminjaman.student_id = students.id 
                        INNER JOIN books ON peminjaman.kd_buku = books.kd_buku 
                        ORDER BY peminjaman.id DESC";
            }
            $stmt = $koneksi->prepare($query);
            $stmt->execute();
            $peminjamans = $stmt->get_result();
            while ($peminjaman = $peminjamans->fetch_object()) {  ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                    <td class="px-6 py-4">
                        <?= htmlspecialchars($peminjaman->student_name) ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars($peminjaman->book_title) ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars($peminjaman->jumlah_peminjaman ?? 0) ?>
                    </td>
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= htmlspecialchars($peminjaman->officer_name) ?>
                    </td>
                    <td class="px-6 py-4 ">
                        <?php if ($peminjaman->status == 'dikembalikan') { ?>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded dark:bg-green-900 dark:text-green-300">Dikembalikan</span>
                        <?php } elseif ($peminjaman->status == 'dipinjam') { ?>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded dark:bg-red-900 dark:text-red-300">Belum Dikembalikan</span>
                        <?php } elseif ($peminjaman->status == 'dipinjam') { ?>
                            <span class="text-red-600 font-medium">Belum Dikembalikan</span>
                        <?php } ?>
                    </td>

                    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'petugas') { ?>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center justify-center w-full">
                                <div class="inline-flex items-center gap-2 justify-center w-full">
                                    <?php $lowerAndNotDash = strtolower(str_replace('-', '', $peminjaman->id)); ?>
                                    <button data-popover-target="popover-edit<?= $lowerAndNotDash ?>" data-modal-target="edit-modal<?= $lowerAndNotDash ?>" data-modal-toggle="edit-modal<?= $lowerAndNotDash ?>" type="button" class="p-2 text-xs cursor-pointer font-medium text-center inline-flex items-center text-white bg-violet-700 rounded-md hover:bg-violet-800 focus:ring-4 focus:outline-none focus:ring-violet-300 dark:bg-violet-600 dark:hover:bg-violet-700 dark:focus:ring-violet-800">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <div data-popover id="popover-edit<?= $lowerAndNotDash ?>" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-md shadow-md opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                        <div class="px-2 popcover-content">
                                            <p>Edit</p>
                                        </div>
                                        <div data-popper-arrow class="shadow"></div>
                                    </div>

                                    <button data-popover-target="popover-delete<?= $lowerAndNotDash ?>" data-modal-target="delete-modal<?= $lowerAndNotDash ?>" data-modal-toggle="delete-modal<?= $lowerAndNotDash ?>" type="button" class="p-2 text-xs cursor-pointer font-medium text-center inline-flex items-center text-white bg-red-700 rounded-md hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        <svg class=" w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <span class="sr-only">Delete</span>
                                    </button>
                                    <div data-popover id="popover-delete<?= $lowerAndNotDash ?>" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-md shadow-md opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                        <div class="px-2 popcover-content">
                                            <p>Hapus</p>
                                        </div>
                                        <div data-popper-arrow class="shadow"></div>
                                    </div>

                                    <div id="edit-modal<?= $lowerAndNotDash ?>" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center  w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <?php
                                            $peminjaman = $koneksi->query(
                                                "SELECT peminjaman.*, officers.id AS officer_id, officers.nama AS officer_name, 
                                            students.id AS student_id, students.nama_siswa AS student_name, 
                                            books.kd_buku, books.title AS book_title
                                        FROM peminjaman
                                        INNER JOIN officers ON peminjaman.officer_id = officers.id 
                                        INNER JOIN students ON peminjaman.student_id = students.id 
                                        INNER JOIN books ON peminjaman.kd_buku = books.kd_buku 
                                        WHERE peminjaman.id='$peminjaman->id'"
                                            )->fetch_object(); ?>
                                            <form class="relative text-left bg-white rounded-lg shadow-sm dark:bg-gray-700 bookForm" action="../Requests/PeminjamanRequest.php?action=update" method="POST">
                                                <!-- Modal header -->
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($peminjaman->id); ?>" />
                                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Edit Data Peminjaman Buku
                                                    </h3>
                                                    <button type="button" class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-modal<?= $lowerAndNotDash ?>">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-4 md:p-5 space-y-4">
                                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                                        <?php $students = $koneksi->query("SELECT * FROM students");
                                                        if ($students && $students->num_rows > 0) { ?>
                                                            <div>
                                                                <label for="student" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Siswa <span class="text-red-400">*</span></label>
                                                                <select id="student" name="student_id" required class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                                                    <?php while ($student = $students->fetch_object()) { ?>
                                                                        <option value="<?= htmlspecialchars($student->id) ?>" <?= $student->id == $peminjaman->student_id ? 'selected' : '' ?>><?= htmlspecialchars($student->nama_siswa) ?></option>
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
                                                                        <option value="<?= htmlspecialchars($officer->id) ?>" <?= $officer->id == $peminjaman->officer_id ? 'selected' : '' ?>><?= htmlspecialchars($officer->nama) ?></option>
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
                                                                        <option value="<?= htmlspecialchars($book->kd_buku) ?>" <?= $book->kd_buku == $peminjaman->kd_buku ? 'selected' : '' ?>><?= htmlspecialchars($book->title) ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php } ?>

                                                        <div>
                                                            <label for="jumlah_peminjaman" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Peminjaman <span class="text-red-400">*</span></label>
                                                            <input type="number" name="jumlah_peminjaman" id="jumlah_peminjaman" min="0" value="<?= htmlspecialchars($peminjaman->jumlah_peminjaman) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Jumlah Peminjaman" />
                                                        </div>

                                                        <div>
                                                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status <span class="text-red-400">*</span></label>
                                                            <select id="status" name="status" required class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                                                <option value="dipinjam" <?= $peminjaman->status == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                                                                <option value="dikembalikan" <?= $peminjaman->status == 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button type="submit" class="btn-loading-submit submitBtn flex items-center justify-center cursor-pointer text-white bg-violet-700 hover:bg-violet-800 focus:ring-4 focus:outline-none focus:ring-violet-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-violet-600 dark:hover:bg-violet-700 dark:focus:ring-violet-800">
                                                            <svg aria-hidden="true" role="status" class="hidden spinnerForm w-4 h-4 mr-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                                                            </svg>
                                                            <span class="btn-text text-white submitText">Ubah</span>
                                                        </button>
                                                        <button data-modal-hide="edit-modal<?= $lowerAndNotDash ?>" type="button" class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-violet-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                                <div id="delete-modal<?= $lowerAndNotDash ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <button type="button" class="absolute cursor-pointer top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal<?= $lowerAndNotDash ?>">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-4 md:p-5 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah anda yakin menghapus data?</h3>

                                                <div class="inline-flex items-center justify-center">
                                                    <form action="../Requests/PeminjamanRequest.php?action=delete" method="post"
                                                        class="text-white bookForm cursor-pointer">
                                                        <input type="hidden" name="id" value="<?= $peminjaman->id ?>">
                                                        <button type="submit" class="cursor-pointer submitBtn bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            <svg aria-hidden="true" role="status" class="hidden spinnerForm w-4 h-4 mr-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                                                            </svg>
                                                            <span class="btn-text text-white submitText">Hapus</span>
                                                        </button>
                                                    </form>
                                                    <button data-modal-hide="delete-modal<?= $lowerAndNotDash ?>" type="button" class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-violet-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    <?php } ?>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>