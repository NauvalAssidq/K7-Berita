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
          <p class="mt-1 text-sm text-gray-600">Kelola komentar dan moderasi konten</p>
        </div>
      </div>

      <!-- Flash Messages -->
      <?php if ($this->session->flashdata('success')): ?>
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
          <i class="material-icons-round text-green-600">check_circle</i>
          <?= $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?>
      
      <?php if ($this->session->flashdata('error')): ?>
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
          <i class="material-icons-round text-red-600">error</i>
          <?= $this->session->flashdata('error'); ?>
        </div>
      <?php endif; ?>

      <!-- Main Card Container -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Empty State -->
        <?php if (empty($comments)): ?>
          <div class="p-8 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-50">
              <i class="material-icons-round text-blue-600">comment</i>
            </div>
            <h3 class="mt-3 text-sm font-medium text-gray-900">Tidak ada komentar</h3>
            <p class="mt-1 text-sm text-gray-500">Tidak ada komentar yang perlu dimoderasi saat ini.</p>
          </div>
        <?php else: ?>
          <!-- Table -->
          <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Artikel</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                  <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php foreach ($comments as $index => $comment): ?>
                  <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-700"><?= $index + 1; ?></td>
                    <td class="px-4 py-3 text-sm text-gray-900"><?= htmlspecialchars($comment->author_name); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                      <div class="line-clamp-2"><?= word_limiter(htmlspecialchars($comment->content), 15); ?></div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      <a href="<?= site_url('main/news/' . $comment->news_slug); ?>" target="_blank" 
                         class="text-blue-600 hover:text-blue-800 hover:underline">
                        <?= htmlspecialchars($comment->news_title); ?>
                      </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700"><?= date('d M Y H:i', strtotime($comment->created_at)); ?></td>
                    <td class="px-4 py-3 text-right">
                      <div class="inline-flex items-center gap-2">
                        <a href="<?= site_url('comments/approve/' . $comment->id); ?>" 
                           class="text-gray-400 hover:text-green-600 p-2 rounded-full hover:bg-gray-100" 
                           title="Setujui"
                           onclick="return handleModeration('approve', '<?= addslashes($comment->author_name); ?>')">
                          <i class="material-icons-round text-lg">check_circle</i>
                        </a>
                        <a href="<?= site_url('comments/reject/' . $comment->id); ?>" 
                           class="text-gray-400 hover:text-yellow-600 p-2 rounded-full hover:bg-gray-100" 
                           title="Tolak"
                           onclick="return handleModeration('reject', '<?= addslashes($comment->author_name); ?>')">
                          <i class="material-icons-round text-lg">cancel</i>
                        </a>
                        <a href="<?= site_url('comments/delete/' . $comment->id); ?>" 
                           class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-gray-100" 
                           title="Hapus"
                           onclick="return handleModeration('delete', '<?= addslashes($comment->author_name); ?>')">
                          <i class="material-icons-round text-lg">delete</i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
</div>

<?php $this->load->view('dashboard/partials/confirmation_modal'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 async function handleModeration(action, authorName) {
    const messages = {
        'approve': `Setujui komentar dari ${authorName}?`,
        'reject': `Tolak komentar dari ${authorName}?`,
        'delete': `Hapus permanen komentar dari ${authorName}?`
    };
    
    try {
        const confirmed = await window.confirmationDialog.show({
            title: 'Konfirmasi Tindakan',
            message: messages[action] || 'Anda yakin ingin melakukan tindakan ini?',
            type: action,
            confirmText: action === 'delete' ? 'Hapus' : 'Ya'
        });
        
        return confi// Enhanced confirmation handling
        rmed;
    } catch (error) {
        console.error('Error:', error);
        return false;
    }
}
</script>
</body>
</html>