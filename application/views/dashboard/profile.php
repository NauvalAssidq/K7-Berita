<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - <?= CMS_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>    
</head>
<body class="h-full font-['Inter'] antialiased">
<div class="flex h-screen">
    <?php $this->load->view('dashboard/partials/sidebar'); ?>
    <main id="mainContent" style="width: calc(100% - 4.5rem); margin-left: 4.5rem;" class="transition-all duration-300">
        <?php $this->load->view('dashboard/partials/header'); ?>
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Pengaturan Profil</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola informasi akun dan pengaturan keamanan Anda</p>
                </div>
            </div>

            <!-- Pesan Notifikasi -->
            <?php if (isset($error)): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
                <i class="material-icons-round text-red-600">error</i>
                <div class="text-red-700 text-sm"><?= $error; ?></div>
            </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('message')): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <i class="material-icons-round text-green-600">check_circle</i>
                <div class="text-green-700 text-sm"><?= $this->session->flashdata('message'); ?></div>
            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kartu Informasi Akun -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-base font-medium text-gray-900">Informasi Akun</h3>
                        <p class="text-sm text-gray-500 mt-1">Perbarui detail profil dasar Anda</p>
                    </div>
                    
                    <form action="<?= site_url('profile'); ?>" method="post" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Lengkap -->
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="full_name" value="<?= set_value('full_name', $user->full_name); ?>" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Username -->
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                                <input type="text" name="username" value="<?= set_value('username', $user->username); ?>" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Email -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                <input type="email" name="email" value="<?= set_value('email', $user->email); ?>" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Bagian Foto Profil -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Foto Profil</label>
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <?php 
                                    // Periksa keberadaan gambar
                                    $image_path = !empty($user->profile_image) ? FCPATH . $user->profile_image : '';
                                    $valid_image = (!empty($user->profile_image) && file_exists($image_path));
                                    ?>
                                    
                                    <?php if ($valid_image): ?>
                                        <!-- Tampilkan foto profil sebenarnya -->
                                        <img src="<?= htmlspecialchars(base_url($user->profile_image)) ?>" 
                                            class="h-16 w-16 rounded-full object-cover border-2 border-white shadow-sm"
                                            alt="<?= htmlspecialchars($user->full_name) ?>'s profile picture">
                                    <?php else: ?>
                                        <!-- Avatar fallback -->
                                        <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="material-icons-round text-gray-400 text-2xl">person</i>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Tombol unggah gambar -->
                                    <div class="absolute bottom-0 right-0 bg-white p-1 rounded-full shadow-sm hover:bg-gray-50 transition-colors">
                                        <label class="cursor-pointer flex items-center">
                                            <i class="material-icons-round text-blue-600 text-sm">edit</i>
                                            <input type="file" 
                                                name="profile_image" 
                                                accept="image/jpeg, image/png" 
                                                class="hidden"
                                                onchange="previewImage(this)">
                                        </label>
                                    </div>
                                </div>

                                <!-- Panduan Gambar -->
                                <div class="text-sm text-gray-500">
                                    <p class="mb-1">✓ Ukuran disarankan: 200x200 piksel</p>
                                    <p class="mb-1">✓ Ukuran maksimal: 2MB</p>
                                    <p>✓ Format: JPEG, PNG</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Kartu Pengaturan Keamanan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-fit">
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-base font-medium text-gray-900">Pengaturan Keamanan</h3>
                        <p class="text-sm text-gray-500 mt-1">Perbarui kata sandi Anda</p>
                    </div>

                    <!-- Kolom Kata Sandi -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="new_password" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                            <input type="password" name="confirm_password" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-6">
                        <button type="button" 
                                onclick="handleSaveChanges()"
                                class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Simpan Perubahan
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php $this->load->view('dashboard/partials/confirmation_modal'); ?>

<script>
function previewImage(input) {
    const preview = input.closest('.relative').querySelector('img');
    const fallback = input.closest('.relative').querySelector('div');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            if (preview) {
                preview.src = e.target.result;
            } else {
                fallback.innerHTML = `<img src="${e.target.result}" 
                                      class="h-16 w-16 rounded-full object-cover border-2 border-white shadow-sm">`;
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

async function handleSaveChanges() {
    try {
        const confirmed = await window.confirmationDialog.show({
            title: 'Simpan Perubahan',
            message: 'Apakah Anda yakin ingin memperbarui pengaturan profil Anda?',
            type: 'save',
            icon: 'save',
            confirmText: 'Ya'
        });

        if(confirmed) {
            document.querySelector('form').submit();
        }
    } catch(error) {
        console.error('Kesalahan konfirmasi:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.confirmationDialog = new ConfirmationDialog();
});
</script>
</body>
</html>
