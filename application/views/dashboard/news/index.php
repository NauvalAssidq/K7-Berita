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
          <p class="mt-1 text-sm text-gray-600">Kelola artikel berita dan konten media</p>
        </div>
        <a href="<?= site_url('news/create'); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="material-icons-round text-lg">add</i>
          <span class="text-sm">Buat Artikel Berita</span>
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
      
      <!-- News List Container -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Search Form -->
        <div class="px-5 py-4 border-b border-gray-200 flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between items-start sm:items-center">
          <form method="GET" action="<?= site_url('news'); ?>" class="flex-1 max-w-md w-full">
            <div class="relative">
              <input type="text" name="search" value="<?= set_value('search', $search); ?>" 
                     placeholder="Cari berita..." 
                     class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                <i class="material-icons-round">search</i>
              </button>
            </div>
          </form>
        </div>
        
        <!-- Bulk Actions and Table -->
        <form id="bulk-action-form" method="POST" action="<?= site_url('news/bulk_delete'); ?>">
          <div class="px-5 py-3 border-b border-gray-200 flex justify-end items-center gap-3">
            <span id="selected-count" class="text-sm font-medium text-gray-700">0 terpilih</span>
            <button type="button" 
                    id="bulk-delete-btn" 
                    class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-lg hover:bg-red-100 disabled:opacity-50 disabled:pointer-events-none" 
                    disabled>
              <i class="material-icons-round">delete</i>
              Hapus Terpilih
            </button>
          </div>
          
          <!-- Table -->
          <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="w-12 px-4 py-3 text-left">
                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                  </th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat Pada</th>
                  <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php if (!empty($news_list)): ?>
                  <?php foreach ($news_list as $index => $news): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                      <td class="px-4 py-3">
                        <input type="checkbox" name="selected_news[]" value="<?= $news->id; ?>" class="news-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                      </td>
                      <td class="px-4 py-3 text-sm text-gray-700"><?= $index + 1 + $offset; ?></td>
                      <td class="px-4 py-3 text-sm text-gray-900">
                        <a href="<?= site_url('main/news/' . $news->slug); ?>" target="_blank" 
                           class="text-blue-600 hover:text-blue-800 hover:underline">
                          <?= htmlspecialchars($news->title); ?>
                        </a>
                      </td>
                      <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($news->category_name ?? 'Tidak Berkategori'); ?></td>
                      <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($news->author_name ?? 'Admin'); ?></td>
                      <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?= $news->published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                          <?= $news->published ? 'Terbit' : 'Konsep' ?>
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm text-gray-700"><?= date('d M Y', strtotime($news->created_at)); ?></td>
                      <td class="px-4 py-3 text-right">
                        <div class="inline-flex items-center gap-3">
                          <a href="<?= site_url('news/edit/' . $news->id); ?>" 
                             class="text-gray-400 hover:text-blue-600 p-1 rounded-full hover:bg-gray-100" 
                             title="Sunting">
                            <i class="material-icons-round text-lg">edit</i>
                          </a>
                          <a href="<?= site_url('news/delete/' . $news->id); ?>" 
                             class="text-gray-400 hover:text-red-600 p-1 rounded-full hover:bg-gray-100" 
                             title="Hapus"
                             onclick="return handleSingleDelete(event, '<?= htmlspecialchars($news->title); ?>')">
                            <i class="material-icons-round text-lg">delete</i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                      Tidak ada artikel berita yang ditemukan.
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </form>
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-b-lg">
          <div class="flex items-center justify-between">
            <?php if(!empty($pagination)): ?>
              <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-end">
                <?php echo $pagination; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Include confirmation modal and scripts -->
<?php $this->load->view('dashboard/partials/confirmation_modal'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Bulk delete handler
async function handleBulkDelete() {
    const checkedCount = $('.news-checkbox:checked').length;
    try {
        const confirmed = await window.confirmationDialog.show({
            title: `Hapus ${checkedCount} Artikel?`,
            message: `Ini akan menghapus secara permanen ${checkedCount} artikel berita yang dipilih.`,
            type: 'bulk_delete'
        });
        if (confirmed) {
            $('#bulk-action-form').submit();
        }
    } catch (error) {
        console.error('Kesalahan konfirmasi:', error);
    }
}

// Single delete handler
async function handleSingleDelete(event, title) {
    event.preventDefault();
    const deleteUrl = event.currentTarget.href;
    try {
        const confirmed = await window.confirmationDialog.show({
            title: `Hapus "${title}"?`,
            message: 'Artikel ini akan dihapus secara permanen.',
            type: 'single_delete'
        });
        if (confirmed) {
            window.location.href = deleteUrl;
        }
    } catch (error) {
        console.error('Kesalahan konfirmasi:', error);
    }
}

// Checkbox handlers
$(document).ready(function() {
    $('#bulk-delete-btn').on('click', handleBulkDelete);
    $('#select-all').on('click', function() {
        $('.news-checkbox').prop('checked', this.checked);
        updateSelectionCount();
    });
    $('.news-checkbox').on('change', updateSelectionCount);
});

function updateSelectionCount() {
    const checkedCount = $('.news-checkbox:checked').length;
    $('#bulk-delete-btn').prop('disabled', checkedCount === 0);
    $('#selected-count').text(checkedCount + ' terpilih');
}
</script>
</body>
</html>