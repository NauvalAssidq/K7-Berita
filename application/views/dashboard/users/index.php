<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> - <?= CMS_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full antialiased font-['Inter']">
<div class="flex h-screen">
    <?php $this->load->view('dashboard/partials/sidebar'); ?>
    <main id="mainContent" style="width: calc(100% - 4.5rem); margin-left: 4.5rem;" class="transition-all duration-300">
        <?php $this->load->view('dashboard/partials/header');?>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900"><?= $title; ?></h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola pengguna sistem dan izin</p>
                </div>
            </div>
            <?php if($this->session->flashdata('message')): ?>
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
                    <i class="material-icons-round text-green-600">check_circle</i>
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
                    <i class="material-icons-round text-red-600">error</i>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-5 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex-1 max-w-md w-full">
                        <form method="GET" action="<?= site_url('users'); ?>">
                            <div class="relative">
                                <input type="text" name="search" value="<?= set_value('search', $search); ?>" 
                                    placeholder="Cari pengguna..." 
                                    class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                                    <i class="material-icons-round">search</i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="selected-count" class="text-sm text-gray-600">0 terpilih</span>
                        <button type="button" id="bulk-delete-btn"
                                class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-lg hover:bg-red-100 disabled:opacity-50 disabled:pointer-events-none"
                                disabled onclick="handleBulkDelete()">
                            <i class="material-icons-round">delete</i>
                            Hapus Terpilih
                        </button>
                    </div>
                </div>
                <form id="bulk-action-form" method="POST" action="<?= site_url('users/bulk_delete'); ?>">
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-4 py-3 text-left">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peran</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $index => $user): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <input type="checkbox" name="selected_users[]" value="<?= $user->id; ?>" 
                                                    class="user-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($user->full_name); ?></span>
                                                    <span class="text-sm text-gray-500"><?= htmlspecialchars($user->email); ?></span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-sm text-gray-900"><?= htmlspecialchars($user->username); ?></span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    <?= match($user->role) {
                                                        'admin' => 'bg-purple-100 text-purple-800',
                                                        'writer' => 'bg-blue-100 text-blue-800',
                                                        'editor' => 'bg-green-100 text-green-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    } ?>">
                                                    <?= htmlspecialchars(ucfirst($user->role)); ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="inline-flex items-center gap-3">
                                                    <a href="<?= site_url('users/edit/' . $user->id); ?>" 
                                                    class="text-gray-400 hover:text-blue-600 p-1 rounded-full hover:bg-gray-100"
                                                    title="Sunting">
                                                        <i class="material-icons-round text-lg">edit</i>
                                                    </a>
                                                    <a href="<?= site_url('users/delete/' . $user->id); ?>" 
                                                    class="text-gray-400 hover:text-red-600 p-1 rounded-full hover:bg-gray-100"
                                                    title="Hapus"
                                                    onclick="handleSingleDelete(event, '<?= htmlspecialchars($user->full_name); ?>')">
                                                        <i class="material-icons-round text-lg">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                            Tidak ada pengguna ditemukan
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-b-lg">
                    <div class="flex items-center justify-between">
                        <?php if(!empty($pagination)): ?>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-end">
                                <div>
                                    <?php echo $pagination; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php $this->load->view('dashboard/partials/confirmation_modal'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select-all').on('click', function() {
            $('.user-checkbox').prop('checked', this.checked);
            toggleBulkDeleteButton();
        });
        $('.user-checkbox').on('change', toggleBulkDeleteButton);
        
        function toggleBulkDeleteButton() {
            const checkedCount = $('.user-checkbox:checked').length;
            $('#selected-count').text(checkedCount + ' terpilih');
            $('#bulk-delete-btn').prop('disabled', checkedCount === 0);
        }
        toggleBulkDeleteButton();
    });
    async function handleBulkDelete() {
        const checkedCount = $('.user-checkbox:checked').length;
        try {
            const confirmed = await window.confirmationDialog.show({
                title: `Hapus ${checkedCount} Pengguna?`,
                message: `Anda akan menghapus secara permanen ${checkedCount} pengguna. Tindakan ini tidak dapat dibatalkan.`,
                type: 'bulk_delete',
                confirmText: 'Hapus'
            });
            if (confirmed) {
                $('#bulk-action-form').submit();
            }
        } catch(error) {
            console.error('Kesalahan dialog konfirmasi:', error);
        }
    }
    async function handleSingleDelete(event, fullName) {
        event.preventDefault();
        const deleteUrl = event.currentTarget.href;
        try {
            const confirmed = await window.confirmationDialog.show({
                title: `Hapus "${fullName}"?`,
                message: `Pengguna "${fullName}" akan dihapus secara permanen.`,
                type: 'single_delete',
                confirmText: 'Hapus'
            });
            if (confirmed) {
                window.location.href = deleteUrl;
            }
        } catch(error) {
            console.error('Kesalahan dialog konfirmasi:', error);
        }
    }
</script>
</body>
</html>
