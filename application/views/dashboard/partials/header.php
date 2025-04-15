<?php 
  $notifications = isset($notifications) ? $notifications : [];
  $notif_count = count($notifications);

  $image_path = !empty($user->profile_image) ? FCPATH . $user->profile_image : '';
  $valid_image = (!empty($user->profile_image) && file_exists($image_path));
?>
<nav class="sticky top-0 z-30 bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center" 
     x-data="{ notifOpen: false, profileOpen: false }"
     @keydown.escape="notifOpen = false; profileOpen = false">
  <div class="flex items-center">
    <h2 class="text-lg font-medium text-gray-800">
    </h2>
  </div>
  <div class="flex items-center space-x-5">
    <div class="relative">
      <button @click="notifOpen = !notifOpen; profileOpen = false" class="relative p-1.5 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-50 transition-colors">
        <i class="material-icons-round text-blue-600 text-2xl">notifications</i>
        <?php if($notif_count > 0): ?>
          <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-white text-xs font-semibold">
            <?= $notif_count ?>
          </span>
        <?php endif; ?>
      </button>
      <!-- Notifications dropdown -->
      <div x-show="notifOpen"
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 translate-y-1"
           x-transition:enter-end="opacity-100 translate-y-0"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 translate-y-0"
           x-transition:leave-end="opacity-0 translate-y-1"
           @click.outside="notifOpen = false"
           class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border border-gray-200"
           style="display: none">
        <div class="p-4 space-y-3">
          <div class="flex items-center justify-between px-2">
            <h3 class="text-sm font-medium text-gray-800">Notifikasi</h3>
            <?php if ($notif_count > 0): ?>
              <a href="<?= site_url('notifications/mark_all_read') ?>" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Tandai semua dibaca</a>
            <?php endif; ?>
          </div>
          <div class="max-h-96 overflow-y-auto space-y-2">
            <?php if ($notif_count > 0): ?>
              <?php foreach ($notifications as $notif): ?>
                <?php
                  $iconConfig = [
                    'leave_request' => ['svg' => 'calendar', 'color' => 'text-purple-600'],
                    'leave_approved' => ['svg' => 'check', 'color' => 'text-green-600'],
                    'leave_rejected' => ['svg' => 'x', 'color' => 'text-red-600'],
                    'payroll' => ['svg' => 'currency-dollar', 'color' => 'text-teal-600'],
                    'attendance' => ['svg' => 'clock', 'color' => 'text-orange-600']
                  ];
                  $icon = $iconConfig[$notif['type']] ?? ['svg' => 'info', 'color' => 'text-blue-600'];
                ?>
                <a href="<?= site_url('notifications/read/'.$notif['id']) ?>" class="flex items-start p-3 space-x-3 rounded-lg hover:bg-gray-50 transition-colors <?= !$notif['is_read'] ? 'bg-blue-50 border-l-4 border-blue-500' : 'bg-white' ?>">
                  <div class="flex-shrink-0 mt-0.5 <?= $icon['color'] ?>">
                    <?php switch($icon['svg']):
                      case 'calendar': ?>
                        <i class="material-icons-round text-lg">event</i>
                        <?php break; case 'check': ?>
                        <i class="material-icons-round text-lg">check</i>
                        <?php break; case 'x': ?>
                        <i class="material-icons-round text-lg">close</i>
                        <?php break; case 'currency-dollar': ?>
                        <i class="material-icons-round text-lg">attach_money</i>
                        <?php break; case 'clock': ?>
                        <i class="material-icons-round text-lg">access_time</i>
                        <?php break; default: ?>
                        <i class="material-icons-round text-lg">info</i>
                    <?php endswitch; ?>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm <?= $notif['is_read'] ? 'text-gray-600' : 'text-gray-900 font-medium' ?>">
                      <?= htmlspecialchars($notif['message']) ?>
                    </p>
                    <p class="text-xs text-gray-400 mt-1"><?= date('d M H:i', strtotime($notif['created_at'])) ?></p>
                  </div>
                </a>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="p-4 text-center">
                <p class="text-gray-400 text-sm">Tidak ada notifikasi baru</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="relative">
      <button @click="profileOpen = !profileOpen; notifOpen = false" class="flex items-center space-x-2 group focus:outline-none">
        <?php if($valid_image): ?>
          <img src="<?= htmlspecialchars(base_url($user->profile_image)) ?>" 
               class="h-9 w-9 rounded-full object-cover border-2 border-gray-200 shadow-sm"
               alt="<?= htmlspecialchars($user->full_name) ?>'s profile picture">
        <?php else: ?>
          <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full">
            <span class="text-gray-500 text-lg"><?= substr($this->session->userdata('username'), 0, 1) ?></span>
          </div>
        <?php endif; ?>
        <span class="text-sm text-gray-700 font-medium group-hover:text-gray-900 transition-colors">
          <?= $this->session->userdata('username'); ?>
        </span>
        <i class="material-icons-round text-gray-400 transform transition-transform text-base" :class="{ 'rotate-180': profileOpen }">expand_more</i>
      </button>
      <div x-show="profileOpen"
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 translate-y-1"
           x-transition:enter-end="opacity-100 translate-y-0"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 translate-y-0"
           x-transition:leave-end="opacity-0 translate-y-1"
           @click.outside="profileOpen = false"
           class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg z-50 border border-gray-200 divide-y divide-gray-200"
           style="display: none">
        <div class="p-2">
          <a href="<?= site_url('profile'); ?>" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
            <i class="material-icons-round text-gray-600 mr-3">person</i>Profil
          </a>
          <a href="<?= site_url('settings'); ?>" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
            <i class="material-icons-round text-gray-600 mr-3">settings</i>Pengaturan
          </a>
        </div>
        <div class="p-2">
          <a href="<?= site_url('auth/logout'); ?>" class="flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors">
            <i class="material-icons-round text-red-600 mr-3">logout</i>Keluar
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
