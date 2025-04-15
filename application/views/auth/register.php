<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <title>Daftar - K7 Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="h-full font-['Inter'] antialiased">
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-2xl border border-gray-300 p-8 space-y-8">
            <div class="text-center space-y-2">
                <div class="inline-flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                    <h1 class="text-4xl font-black text-blue-600">K7 Berita</h1>
                </div>
                <p class="text-gray-600 text-sm tracking-wide">Bergabunglah dengan komunitas teknologi kami</p>
            </div>

            <?php if(isset($error) || isset($errors)): ?>
            <div class="rounded-lg bg-red-50 p-4 border border-red-100 flex items-start gap-3 animate-fade-in">
                <i class="material-icons-round text-red-500 text-xl">error_outline</i>
                <p class="text-sm text-red-700 flex-1 leading-tight"><?= $error ?? $errors ?></p>
            </div>
            <?php endif; ?>

            <form class="space-y-6" action="<?php echo site_url('auth/register'); ?>" method="post">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengguna</label>
                        <div class="relative">
                            <input name="username" type="text" required 
                                class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 
                                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                       outline-none transition-all placeholder-gray-400">
                            <i class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">person</i>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <input name="full_name" type="text" required 
                                class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 
                                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                       outline-none transition-all placeholder-gray-400">
                            <i class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">badge</i>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative">
                            <input name="email" type="email" required 
                                class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 
                                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                       outline-none transition-all placeholder-gray-400">
                            <i class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">email</i>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <input name="password" type="password" required 
                                class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 
                                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                       outline-none transition-all placeholder-gray-400">
                            <i class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">lock</i>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input name="confirm_password" type="password" required 
                                class="w-full px-4 py-3 pl-11 rounded-lg border border-gray-300 
                                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                       outline-none transition-all placeholder-gray-400">
                            <i class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">lock_reset</i>
                        </div>
                    </div>
                </div>
                <button type="submit" 
                        class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold 
                               rounded-lg shadow-md transform transition-all duration-200">
                    Daftar Sekarang
                </button>
            </form>
            <div class="pt-6 border-t border-gray-200">
                <div class="text-center text-sm">
                    <p class="text-gray-500">Sudah memiliki akun?
                        <a href="<?php echo site_url('auth/login'); ?>" 
                           class="text-blue-600 font-medium hover:text-blue-700 hover:underline 
                                  transition-colors duration-200">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8">
                <p class="text-center text-gray-400 text-xs tracking-wide">
                    © 2025 K7 Berita • Seluruh hak cipta dilindungi
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>