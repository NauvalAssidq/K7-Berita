<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kategori - <?php echo CMS_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full antialiased font-['Inter'] text-gray-800">
<div class="flex h-screen">
    <?php $this->load->view('dashboard/partials/sidebar'); ?>

    <main id="mainContent" style="width: calc(100% - 4.5rem); margin-left: 4.5rem;" class="transition-all duration-300">
        <?php $this->load->view('dashboard/partials/header'); ?>

        <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Buat Kategori</h1>
                    <p class="mt-1 text-sm text-gray-600">Tambahkan kategori konten baru untuk organisasi</p>
                </div>
                <a href="<?php echo site_url('categories'); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="material-icons-round text-base">arrow_back</i>
                    <span class="text-sm">Kembali ke kategori</span>
                </a>
            </div>

            <?php if (!empty($error)): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
                    <i class="material-icons-round text-red-600">error</i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <form action="<?php echo site_url('categories/create'); ?>" method="POST" class="p-6 space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" autofocus>
                        <?php echo form_error('name', '<p class="text-red-600 text-xs mt-1">', '</p>'); ?>
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" id="slug" name="slug" value="<?php echo set_value('slug'); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <?php echo form_error('slug', '<p class="text-red-600 text-xs mt-1">', '</p>'); ?>
                    </div>

                    <div class="pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <i class="material-icons-round text-sm">save</i>
                            Buat Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
