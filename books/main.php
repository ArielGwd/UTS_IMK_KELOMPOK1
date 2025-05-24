<?php
require_once '../Helpers/Helper.php';
$kode_buku = Helper::generateKdBuku();
?>
<div class="p-6 md:ml-2 bg-white text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full rounded-lg">
    <div class="flex items-center">
        <div class=" flex-1">
            <h3 class="text-lg font-bold text-xl text-violet-800 dark:text-violet-600">Data Buku</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Berikut adalah data buku yang anda baca</p>
        </div>
        <button data-modal-target="add-modal" data-modal-toggle="add-modal" type="button" class="px-3 py-2 text-xs cursor-pointer font-medium text-center inline-flex items-center text-white bg-green-700 rounded-md hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <svg class=" w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Tambah Data
        </button>
    </div>
</div>

<div class="relative overflow-x-auto pt-2 pl-2 mt-6">
    <?php
    if (isset($_GET['message'])) {
        echo htmlspecialchars($_GET['message']);
    } ?>
    <table id="pagination-table" class="bg-white w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-lg">
        <thead>
            <tr>
                <th scope="col" class="px-6 py-3">
                    Judul Buku
                </th>
                <th scope="col" class="px-6 py-3">
                    Author
                </th>
                <th scope="col" class="px-6 py-3">
                    Tahun Terbit
                </th>

                <th scope="col" class="px-6 py-3">
                    Kategori
                </th>
                <th scope="col" class="px-6 py-3">
                    Jumlah
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Aksi</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../config/request.php';
            $query = 'SELECT books.*, categories.name AS category_name 
                      FROM books 
                      LEFT JOIN categories ON books.category_id = categories.id 
                      ORDER BY books.kd_buku DESC';
            $stmt = $koneksi->prepare($query);
            $stmt->execute();
            $books = $stmt->get_result();

            while ($book = $books->fetch_object()) { ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= htmlspecialchars($book->title) ?>
                    </th>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars($book->author) ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars(date('d F Y', strtotime($book->year_published))) ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars($book->category_name ?? 'Tidak ada') ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars($book->jumlah ?? 0) ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex items-center justify-center w-full">
                            <div class="inline-flex items-center gap-2 justify-center w-full">
                                <?php $lowerAndNotDash = strtolower(str_replace('-', '', $book->kd_buku)); ?>
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
                                        $book = $koneksi->query("SELECT * FROM books WHERE kd_buku='$book->kd_buku'")->fetch_object(); ?>
                                        <form class="relative text-left bg-white rounded-lg shadow-sm dark:bg-gray-700 bookForm" action="../Requests/BookRequest.php?action=update" method="POST">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Edit Data Buku
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
                                                    <div>
                                                        <label for="kode-buku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Buku</label>
                                                        <input type="text" id="kode-buku" name="kd_buku" aria-label="disabled input 2" value="<?= htmlspecialchars($book->kd_buku); ?>" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-violet-500 dark:focus:border-violet-500" readonly>
                                                    </div>
                                                    <div>
                                                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku <span class="text-red-400">*</span></label>
                                                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book->title) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Habibie & Ainun" />
                                                    </div>
                                                    <div>
                                                        <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author <span class="text-red-400">*</span></label>
                                                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book->author) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="BJ. Habibie" />
                                                    </div>
                                                    <div>
                                                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Terbit <span class="text-red-400">*</span></label>
                                                        <input type="date" name="year_published" value="<?= htmlspecialchars($book->year_published) ?>" required id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                                    </div>

                                                    <div>
                                                        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Buku <span class="text-red-400">*</span></label>
                                                        <input type="number" id="jumlah" name="jumlah" value="<?= htmlspecialchars($book->jumlah ?? 0) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="0" />
                                                    </div>

                                                    <?php $categories = $koneksi->query("SELECT * FROM categories");
                                                    if ($categories && $categories->num_rows > 0) { ?>
                                                        <div>
                                                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori <span class="text-red-400">*</span></label>
                                                            <select id="category" name="category_id" required class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                                                <?php while ($category = $categories->fetch_object()) { ?>
                                                                    <option value="<?= htmlspecialchars($category->id) ?>" <?= $category->id == $book->category_id ? 'selected' : '' ?>><?= htmlspecialchars($category->name) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div>
                                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                                                    <textarea id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Deskripsi buku"><?= htmlspecialchars($book->description) ?></textarea>
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
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah anda yakin menghapus buku <?= $book->title ?>?</h3>

                                                <div class="inline-flex items-center justify-center">
                                                    <form action="../Requests/BookRequest.php?action=delete" method="post"
                                                        class="text-white bookForm cursor-pointer">
                                                        <input type="hidden" name="kd_buku" value="<?= $book->kd_buku ?>">
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
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- tambah buku -->
<div id="add-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <form class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700" id="addBookForm" action="../Requests/BookRequest.php?action=add" method="POST">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Data Buku
                </h3>
                <button type="button" class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-modal">
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
                    <div>
                        <label for="kode-buku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Buku</label>
                        <input type="text" id="kode-buku" name="kd_buku" aria-label="disabled input 2" value="<?php echo ($kode_buku); ?>" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-violet-500 dark:focus:border-violet-500" readonly>
                    </div>
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku <span class="text-red-400">*</span></label>
                        <input type="text" id="title" name="title" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Habibie & Ainun" />
                    </div>
                    <div>
                        <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author <span class="text-red-400">*</span></label>
                        <input type="text" id="author" name="author" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="BJ. Habibie" />
                    </div>
                    <div>
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Terbit <span class="text-red-400">*</span></label>
                        <input type="date" name="year_published" required id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                    </div>
                    <div>
                        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah <span class="text-red-400">*</span></label>
                        <input type="number" name="jumlah" min="0" value="0" required id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                    </div>
                    <?php $categories = $koneksi->query("SELECT * FROM categories");
                    if ($categories && $categories->num_rows > 0) { ?>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori <span class="text-red-400">*</span></label>
                            <select id="category" name="category_id" required class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500">
                                <?php while ($category = $categories->fetch_object()) { ?>
                                    <option value="<?= htmlspecialchars($category->id) ?>"><?= htmlspecialchars($category->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Deskripsi buku"></textarea>
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
                <button data-modal-hide="add-modal" type="button" class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-violet-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
            </div>
        </form>
    </div>
</div>