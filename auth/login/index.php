<?php
include '../../config/request.php';
session_start();

if (isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library - Aplikasi Pencatatan Peminjaman Buku</title>
    <link rel="icon" href="../../assets/img/logo-unsia.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <main>
        <section>
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="../../auth/login/" class="flex items-center mb-6 text-3xl font-semibold text-gray-700 dark:text-white">
                    <svg class="w-7 h-7 text-indigo-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 14h-2.722L11 20.278a5.511 5.511 0 0 1-.9.722H20a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM9 3H4a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V4a1 1 0 0 0-1-1ZM6.5 18.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM19.132 7.9 15.6 4.368a1 1 0 0 0-1.414 0L12 6.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z" />
                    </svg>
                    <span>Library</span>
                </a>
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-xl dark:text-white">
                            Sign in
                        </h1>
                        <form class="space-y-4" action="../../Requests/AuthRequest.php?action=login" method="POST" id="addBookForm">
                            <div class="text-red-500 text-sm">
                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                                        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-medium">Pengertian !</span>
                                            <?php echo $_SESSION['error'];
                                            unset($_SESSION['error']); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input
                                    type="text" id="username" name="username"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                                    placeholder="your_username" />
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input
                                    type="password" id="password" name="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                                    placeholder="••••••••" />
                            </div>

                            <!-- <div class="flex items-center justify-between">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                </label>
                                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                            </div> -->

                            <button id="submitBtn" class="flex items-center justify-center cursor-pointer w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
                                <svg id="spinner" aria-hidden="true" role="status" class="hidden w-4 h-4 mr-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                                </svg>
                                <span class="btn-text text-white" id="btnText">Sign In</span>
                            </button>
                        </form>
                    </div>
                </div>
                <?php include '../../layout/footer.php'; ?>

            </div>
        </section>
    </main>

    <script src="../../assets/js/static.js"></script>
    <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>