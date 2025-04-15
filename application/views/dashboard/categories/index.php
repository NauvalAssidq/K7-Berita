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
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900"><?= $title; ?></h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola kategori konten dan organisasi</p>
                </div>
                <a href="<?= site_url('categories/create'); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="material-icons-round text-base">add</i>
                    <span class="text-sm">Buat Kategori</span>
                </a>
            </div>

            <!-- Flash messages -->
            <?php if ($this->session->flashdata('message')): ?>
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
                    <i class="material-icons-round text-green-600">check_circle</i>
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
                    <i class="material-icons-round text-red-600">error</i>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Categories List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Search Form -->
                <div class="px-5 py-4 border-b border-gray-200 flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between items-start sm:items-center">
                    <form method="GET" action="<?= site_url('categories'); ?>" class="flex-1 max-w-md w-full">
                        <div class="relative">
                            <input type="text" name="search" value="<?= set_value('search', $search); ?>" placeholder="Cari kategori..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                                <i class="material-icons-round">search</i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Bulk Actions and Table -->
                <form id="bulk-action-form" method="POST" action="<?= site_url('categories/bulk_delete'); ?>">
                    <div class="px-5 py-3 border-b border-gray-200 flex items-center justify-end gap-3">
                        <span id="selected-count" class="text-sm text-gray-600">0 terpilih</span>
                        <button type="button" id="bulk-delete-btn" onclick="handleBulkDelete()" class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-lg hover:bg-red-100 disabled:opacity-50 disabled:pointer-events-none" disabled>
                            <i class="material-icons-round">delete</i>
                            Hapus Terpilih
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-4 py-3 text-left">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <input type="checkbox" name="category_ids[]" value="<?= $category->id; ?>" class="category-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900"><?= htmlspecialchars($category->name); ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-500"><?= htmlspecialchars($category->slug); ?></td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="inline-flex items-center gap-3">
                                                    <a href="<?= site_url('categories/edit/' . $category->id); ?>" class="text-gray-400 hover:text-blue-600 p-1 rounded-full hover:bg-gray-100" title="Sunting">
                                                        <i class="material-icons-round text-lg">edit</i>
                                                    </a>
                                                    <a href="<?= site_url('categories/delete/' . $category->id); ?>" class="text-gray-400 hover:text-red-600 p-1 rounded-full hover:bg-gray-100" title="Hapus" onclick="handleSingleDelete(event, '<?= htmlspecialchars($category->name); ?>')">
                                                        <i class="material-icons-round text-lg">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada kategori ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-b-lg">
                    <?php if (!empty($pagination)): ?>
                        <div class="flex items-center justify-end">
                            <?= $pagination; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php $this->load->view('dashboard/partials/confirmation_modal'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('#select-all').on('click', function() {
        $('.category-checkbox').prop('checked', this.checked);
        updateSelectionCount();
    });
    $('.category-checkbox').on('change', updateSelectionCount);
});

function updateSelectionCount() {
    const count = $('.category-checkbox:checked').length;
    $('#selected-count').text(count + ' terpilih');
    $('#bulk-delete-btn').prop('disabled', count === 0);
}

async function handleBulkDelete() {
    const count = $('.category-checkbox:checked').length;
    try {
        const confirmed = await window.confirmationDialog.show({
            title: `Hapus ${count} Kategori?`,
            message: `Anda akan menghapus secara permanen ${count} kategori. Tindakan ini tidak dapat dibatalkan.`,
            type: 'bulk_delete',
            confirmText: 'Hapus'
        });
        if (confirmed) $('#bulk-action-form').submit();
    } catch(e) {
        console.error('Konfirmasi error:', e);
    }
}

async function handleSingleDelete(event, name) {
    event.preventDefault();
    const url = event.currentTarget.href;
    try {
        const confirmed = await window.confirmationDialog.show({
            title: `Hapus "${name}"?`,
            message: `Ini akan menghapus secara permanen kategori "${name}" beserta semua konten terkait.`,
            type: 'single_delete',
            confirmText: 'Hapus'
        });
        if (confirmed) window.location.href = url;
    } catch(e) {
        console.error('Konfirmasi error:', e);
    }
}
</script>
</body>
</html>
