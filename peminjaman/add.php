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
    <button type="submit" class="submitBtn btn-loading-submit flex items-center justify-center cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
        <svg aria-hidden="true" role="status" class="hidden spinnerForm w-4 h-4 mr-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
        </svg>
        <span class="btn-text text-white submitText">Tambah</span>
    </button>
    <button data-modal-hide="add-modal-peminjaman" type="button" class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-violet-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
</div>