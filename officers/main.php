<div class="p-6 md:ml-2 bg-white text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full rounded-lg">
    <div class="flex items-center">
        <div class=" flex-1">
            <h3 class="text-lg font-bold text-xl text-violet-800 dark:text-violet-600">Data Petugas</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Berikut adalah data petugas yang terdaftar</p>
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
                    Nama Siswa
                </th>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Aksi</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../config/request.php';
            $query = 'SELECT officers.*, users.* FROM officers 
                      INNER JOIN users ON officers.user_id = users.id 
                      ORDER BY officers.id DESC';
            $stmt = $koneksi->prepare($query);
            $stmt->execute();
            $officers = $stmt->get_result();
            while ($officer = $officers->fetch_object()) {  ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= htmlspecialchars($officer->nama) ?>
                    </th>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars($officer->username) ?>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex items-center justify-center w-full">
                            <div class="inline-flex items-center gap-2 justify-center w-full">
                                <?php $lowerAndNotDash = strtolower(str_replace('-', '', $officer->id)); ?>
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
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] !== $officer->user_id) { ?>
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
                                <?php } ?>


                                <div id="edit-modal<?= $lowerAndNotDash ?>" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center  w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <?php
                                        $officer = $koneksi->query("SELECT officers.*, users.* FROM officers INNER JOIN users ON officers.user_id = users.id WHERE officers.user_id='$officer->user_id'")->fetch_object(); ?>
                                        <form class="relative text-left bg-white rounded-lg shadow-sm dark:bg-gray-700 bookForm" action="../Requests/OfficerRequest.php?action=update" method="POST">
                                            <!-- Modal header -->
                                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($officer->user_id); ?>" />
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Edit Data Petugas
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
                                                        <label for="username-update<?= $lowerAndNotDash ?>" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                                        <input type="text" id="username-update<?= $lowerAndNotDash ?>" name="username" value="<?= htmlspecialchars($officer->username); ?>" class="username bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="sky_seven" required />
                                                    </div>
                                                    <div>
                                                        <label for="nama-update<?= $lowerAndNotDash ?>" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Petugas</label>
                                                        <input type="text" id="nama-update<?= $lowerAndNotDash ?>" name="nama" value="<?= htmlspecialchars($officer->nama); ?>" class="nama bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Habibie" required />
                                                    </div>

                                                    <div>
                                                        <label for="password-update<?= $lowerAndNotDash ?>" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                            Password (<span class="text-red-700">Isi jika ingin mengubah</span>)
                                                        </label>

                                                        <div class="relative">
                                                            <input
                                                                type="password" id="password-update<?= $lowerAndNotDash ?>" name="password" class="password bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Password Anda" />
                                                            <button type="button" id="toggle-password-update<?= $lowerAndNotDash ?>" class="absolute toggle-password cursor-pointer inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-400" aria-label="Toggle password visibility">
                                                                <svg id="eye-open-update<?= $lowerAndNotDash ?>" xmlns="http://www.w3.org/2000/svg" class="eye-open h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.269 2.943 9.542 7-1.273 4.057-5.064 7-9.542 7-4.478 0-8.269-2.943-9.542-7z" />
                                                                </svg>
                                                                <svg id="eye-closed-update<?= $lowerAndNotDash ?>" xmlns="http://www.w3.org/2000/svg" class="eye-closed h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.542-7a9.958 9.958 0 012.626-4.438M6.22 6.22A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.542 7a10.05 10.05 0 01-1.316 2.583M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                                                </svg>
                                                                <span class="sr-only">Toggle password visibility</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="confirm-password-update<?= $lowerAndNotDash ?>" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                            Konfirmasi Password
                                                        </label>

                                                        <div class="relative">
                                                            <input
                                                                type="password" id="confirm-password-update<?= $lowerAndNotDash ?>" name="confirm_password" class="confirm-password bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Password Anda" />
                                                            <button type="button" id="toggle-confirm-password-update<?= $lowerAndNotDash ?>" class="absolute toggle-confirm-password cursor-pointer inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-400" aria-label="Toggle password visibility">
                                                                <svg id="confirm-eye-open-update<?= $lowerAndNotDash ?>" xmlns="http://www.w3.org/2000/svg" class="confirm-eye-open h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.269 2.943 9.542 7-1.273 4.057-5.064 7-9.542 7-4.478 0-8.269-2.943-9.542-7z" />
                                                                </svg>
                                                                <svg id="confirm-eye-closed-update<?= $lowerAndNotDash ?>" xmlns="http://www.w3.org/2000/svg" class="confirm-eye-closed h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.542-7a9.958 9.958 0 012.626-4.438M6.22 6.22A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.542 7a10.05 10.05 0 01-1.316 2.583M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                                                </svg>
                                                                <span class="sr-only">Toggle password visibility</span>
                                                            </button>
                                                        </div>

                                                        <p id="password-error-update<?= $lowerAndNotDash ?>" class="hidden password-error mt-2 text-sm text-red-600 dark:text-red-500">
                                                            Password tidak sama
                                                        </p>
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
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah anda yakin menghapus data <?= $officer->nama ?>?</h3>

                                                <div class="inline-flex items-center justify-center">
                                                    <form action="../Requests/OfficerRequest.php?action=delete" method="post"
                                                        class="text-white bookForm cursor-pointer">
                                                        <input type="hidden" name="user_id" value="<?= $officer->user_id ?>">
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
        <form class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700" id="addBookForm" action="../Requests/OfficerRequest.php?action=add" method="POST">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Data Petugas
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
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <input type="text" id="username" name="username" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="sky_seven" required />
                    </div>
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Petugas</label>
                        <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Habibie" required />
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Password
                        </label>

                        <div class="relative">
                            <input
                                type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Password Anda" required />
                            <button type="button" id="toggle-password" class="absolute cursor-pointer inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-400" aria-label="Toggle password visibility">
                                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.269 2.943 9.542 7-1.273 4.057-5.064 7-9.542 7-4.478 0-8.269-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.542-7a9.958 9.958 0 012.626-4.438M6.22 6.22A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.542 7a10.05 10.05 0 01-1.316 2.583M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                                <span class="sr-only">Toggle password visibility</span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Konfirmasi Password
                        </label>

                        <div class="relative">
                            <input
                                type="password" id="confirm-password" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" placeholder="Password Anda" required />
                            <button type="button" id="toggle-confirm-password" class="absolute cursor-pointer inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-400" aria-label="Toggle password visibility">
                                <svg id="confirm-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.269 2.943 9.542 7-1.273 4.057-5.064 7-9.542 7-4.478 0-8.269-2.943-9.542-7z" />
                                </svg>
                                <svg id="confirm-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.542-7a9.958 9.958 0 012.626-4.438M6.22 6.22A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.542 7a10.05 10.05 0 01-1.316 2.583M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                                <span class="sr-only">Toggle password visibility</span>
                            </button>
                        </div>

                        <p id="password-error" class="hidden password-error mt-2 text-sm text-red-600 dark:text-red-500">
                            Password tidak sama
                        </p>
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
                <button data-modal-hide="add-modal" type="button" class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-violet-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    const usernameInput = document.getElementById('username');
    usernameInput.addEventListener('input', function() {
        this.value = this.value.toLowerCase().replace(/[^a-z0-9_]/g, '');
    });

    const usernameInputs = document.querySelectorAll('.username');
    usernameInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/[^a-z0-9_]/g, '');
        });
    });

    const pwdInputId = document.getElementById('password');
    const toggleBtnId = document.getElementById('toggle-password');
    const eyeOpenId = document.getElementById('eye-open');
    const eyeClosedId = document.getElementById('eye-closed');
    toggleBtnId.addEventListener('click', () => {
        const isPwd = pwdInputId.type === 'password';
        pwdInputId.type = isPwd ? 'text' : 'password';
        eyeOpenId.classList.toggle('hidden');
        eyeClosedId.classList.toggle('hidden');
    });

    const pwdInput = document.querySelectorAll('.password');
    const toggleBtn = document.querySelectorAll('.toggle-password');
    const eyeOpen = document.querySelectorAll('.eye-open');
    const eyeClosed = document.querySelectorAll('.eye-closed');
    toggleBtn.forEach(function(btn, index) {
        btn.addEventListener('click', () => {
            const isPwd = pwdInput[index].type === 'password';
            pwdInput[index].type = isPwd ? 'text' : 'password';
            eyeOpen[index].classList.toggle('hidden');
            eyeClosed[index].classList.toggle('hidden');
        });
    });

    const confirmPwdInputId = document.getElementById('confirm-password');
    const confirmToggleBtnId = document.getElementById('toggle-confirm-password');
    const confirmEyeOpenId = document.getElementById('confirm-eye-open');
    const confirmEyeClosedId = document.getElementById('confirm-eye-closed');
    confirmToggleBtnId.addEventListener('click', () => {
        const isPwd = confirmPwdInputId.type === 'password';
        confirmPwdInputId.type = isPwd ? 'text' : 'password';
        confirmEyeOpenId.classList.toggle('hidden');
        confirmEyeClosedId.classList.toggle('hidden');
    });

    const confirmPwdInput = document.querySelectorAll('.confirm-password');
    const confirmToggleBtn = document.querySelectorAll('.toggle-confirm-password');
    const confirmEyeOpen = document.querySelectorAll('.confirm-eye-open');
    const confirmEyeClosed = document.querySelectorAll('.confirm-eye-closed');
    confirmToggleBtn.forEach(function(btn, index) {
        btn.addEventListener('click', () => {
            const isPwd = confirmPwdInput[index].type === 'password';
            confirmPwdInput[index].type = isPwd ? 'text' : 'password';
            confirmEyeOpen[index].classList.toggle('hidden');
            confirmEyeClosed[index].classList.toggle('hidden');
        });
    });

    confirmPwdInputId.setAttribute('readonly', true);
    confirmPwdInputId.classList.add('bg-gray-200', 'cursor-not-allowed');
    pwdInputId.addEventListener('input', function() {
        if (this.value !== '') {
            confirmPwdInputId.removeAttribute('readonly');
            confirmPwdInputId.classList.remove('bg-gray-200', 'cursor-not-allowed');
        } else {
            confirmPwdInputId.setAttribute('readonly', true);
            confirmPwdInputId.classList.add('bg-gray-200', 'cursor-not-allowed');
        }
    });

    confirmPwdInput.forEach(function(input) {
        input.setAttribute('readonly', true);
        input.classList.add('bg-gray-200', 'cursor-not-allowed');

        pwdInput.forEach(function(pwd) {
            pwd.addEventListener('input', function() {
                if (this.value !== '') {
                    input.removeAttribute('readonly');
                    input.classList.remove('bg-gray-200', 'cursor-not-allowed');
                } else {
                    input.setAttribute('readonly', true);
                    input.classList.add('bg-gray-200', 'cursor-not-allowed');
                }
            });
        });
    });

    confirmPwdInputId.addEventListener('input', function() {
        const password = pwdInputId.value;
        const confirmPassword = this.value;
        const errorElement = document.getElementById('password-error');

        if (password != confirmPassword) {
            errorElement.classList.remove('hidden');
            this.classList.remove('focus:ring-violet-500', 'focus:border-violet-500');
            this.classList.add('border', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        } else {
            errorElement.classList.add('hidden');
            this.classList.add('focus:ring-violet-500', 'focus:border-violet-500');
            this.classList.remove('border', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        }
    });

    confirmPwdInput.forEach(function(input) {
        input.addEventListener('input', function() {
            const password = pwdInput[0].value;
            const confirmPassword = this.value;
            const errorElement = document.querySelector('.password-error');

            if (password != confirmPassword) {
                errorElement.classList.remove('hidden');
                input.classList.remove('focus:ring-violet-500', 'focus:border-violet-500');
                input.classList.add('border', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            } else {
                errorElement.classList.add('hidden');
                input.classList.add('focus:ring-violet-500', 'focus:border-violet-500');
                input.classList.remove('border', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            }
        });
    });
</script>