<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> - <?= CMS_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="h-full antialiased font-['Inter'] text-gray-800">
<div class="flex h-screen">
    <?php $this->load->view('dashboard/partials/sidebar'); ?>
    <main id="mainContent" style="width: calc(100% - 4.5rem); margin-left: 4.5rem;" class="transition-all duration-300">
        <?php $this->load->view('dashboard/partials/header'); ?>
        
        <div class="p-6">
            <!-- Page-specific Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900"><?= $title; ?></h1>
                    <p class="mt-1 text-sm text-gray-600">Perbarui detail pengguna dan izin</p>
                </div>
                <a href="<?= site_url('users'); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="material-icons-round text-sm">arrow_back</i>
                    <span class="text-sm">Kembali ke pengguna</span>
                </a>
            </div>

            <?php if ($this->session->flashdata('message')): ?>
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
                    <i class="material-icons-round text-green-600">check_circle</i>
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
                    <i class="material-icons-round text-red-600">error</i>
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <form action="<?= site_url('users/edit/' . $user_to_edit->id); ?>" method="POST" class="p-6 space-y-6">
                    <!-- CSRF Protection -->
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                    <!-- User Information -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                            <div class="mt-1 p-3 w-full border border-gray-300 bg-gray-50 rounded-lg text-gray-600">
                                <?= htmlspecialchars($user_to_edit->username ?? ''); ?>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <div class="mt-1 p-3 w-full border border-gray-300 bg-gray-50 rounded-lg text-gray-600">
                                <?= htmlspecialchars($user_to_edit->email ?? ''); ?>
                            </div>
                        </div>

                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($user_to_edit->full_name ?? ''); ?>"
                                   class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Masukkan nama lengkap">
                            <?= form_error('full_name', '<p class="text-red-600 text-xs mt-1">', '</p>'); ?>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Peran Pengguna</label>
                        <select id="role" name="role"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-colors">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= strtolower($role); ?>" <?= (strtolower($user_to_edit->role) == strtolower($role)) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($role); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Form Actions -->
                    <div class="pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit" id="save-btn" 
                                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="material-icons-round text-sm">save</i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php $this->load->view('dashboard/partials/confirmation_modal'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.querySelector("form").addEventListener("submit", function() {
        const saveBtn = document.getElementById("save-btn");
        saveBtn.innerHTML = `<i class="material-icons-round animate-spin">autorenew</i> Menyimpan...`;
        saveBtn.disabled = true;
        saveBtn.classList.remove('hover:bg-blue-700');
    });
</script>
</body>
</html>