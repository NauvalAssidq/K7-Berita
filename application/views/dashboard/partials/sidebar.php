<?php
$current_controller = $this->uri->segment(1); 
$is_admin = $this->session->userdata('role') === ROLE_ADMIN;
?>

<nav id="sidebar" class="w-[4.5rem] bg-white border-r border-gray-200 transition-all duration-300 fixed h-full z-50" aria-label="Navigasi Utama">
    <div class="flex flex-col h-full px-3 py-4">
        <button id="toggleSidebar" class="absolute right-[-20px] top-3 bg-white border rounded-md p-1.5 hover:bg-gray-100 transition-all shadow-sm focus:outline-none">
            <i class="material-icons-round text-gray-600 text-xl transition-transform duration-200" id="toggleIcon">menu</i>
        </button>

        <div class="mb-6 px-2 flex justify-center transition-all duration-300">
            <a href="<?= site_url('main'); ?>" class="flex items-center">
                <span class="text-xl font-bold text-blue-600 tracking-tight transition-all duration-300" id="sidebarLogo">
                    <?= substr(CMS_NAME, 0, 2); ?>
                </span>
                <span class="sr-only"><?= html_escape(CMS_NAME) ?></span>
            </a>
        </div>

        <ul class="flex-1 space-y-1">
            <?php $menuItems = [
                ['url' => 'dashboard', 'icon' => 'dashboard', 'text' => 'Dashboard'],
                ['url' => 'news', 'icon' => 'article', 'text' => 'Berita'],
                ['url' => 'categories', 'icon' => 'category', 'text' => 'Kategori'],
                ['url' => 'comments', 'icon' => 'comment', 'text' => 'Komentar'],
                ['url' => 'users', 'icon' => 'people', 'text' => 'Pengguna', 'condition' => $is_admin]
            ]; ?>

            <?php foreach($menuItems as $item): ?>
                <?php if(!isset($item['condition']) || $item['condition']): ?>
                    <li>
                        <a href="<?= site_url($item['url']); ?>" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm <?= ($current_controller === $item['url']) ? 'bg-blue-50 text-blue-600 font-medium border-l-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> transition-colors">
                            <i class="material-icons-round text-xl min-w-[24px]"><?= $item['icon'] ?></i>
                            <span class="sidebar-text hidden"><?= $item['text'] ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <!-- Bottom Menu with improved styling -->
        <ul class="mt-auto space-y-1">
            <li>
                <a href="<?= site_url('profile'); ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors text-sm">
                    <i class="material-icons-round text-xl min-w-[24px]">settings</i>
                    <span class="sidebar-text hidden">Pengaturan</span>
                </a>
            </li>
            <li>
                <button type="button" onclick="handleLogout()"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors text-sm focus:outline-none">
                    <i class="material-icons-round text-xl min-w-[24px]">logout</i>
                    <span class="sidebar-text hidden">Keluar</span>
                </button>
            </li>
        </ul>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const sidebarTextElements = document.querySelectorAll(".sidebar-text");
    const toggleButton = document.getElementById("toggleSidebar");
    const logo = document.getElementById("sidebarLogo");
    const toggleIcon = document.getElementById("toggleIcon");
    const mainContent = document.getElementById("mainContent");

    const isExpanded = localStorage.getItem("sidebarExpanded") === "true";
    setSidebarState(isExpanded);

    toggleButton.addEventListener("click", function () {
        const newState = !sidebar.classList.contains("w-64");
        setSidebarState(newState);
        localStorage.setItem("sidebarExpanded", newState);
    });

    function setSidebarState(expanded) {
        if (expanded) {
            sidebar.classList.add("w-64");
            sidebar.classList.remove("w-[4.5rem]");
            sidebarTextElements.forEach(el => el.classList.remove("hidden"));
            logo.textContent = "<?= CMS_NAME; ?>";
            toggleIcon.innerHTML = 'menu_open';
            if(mainContent) {
                mainContent.style.marginLeft = '16rem';
                mainContent.style.width = 'calc(100% - 16rem)';
                mainContent.style.transition = 'margin-left 0.3s ease, width 0.3s ease';
            }
        } else {
            sidebar.classList.add("w-[4.5rem]");
            sidebar.classList.remove("w-64");
            sidebarTextElements.forEach(el => el.classList.add("hidden"));
            logo.textContent = "<?= substr(CMS_NAME, 0, 2); ?>";
            toggleIcon.innerHTML = 'menu';
            if(mainContent) {
                mainContent.style.marginLeft = '4.5rem';
                mainContent.style.width = 'calc(100% - 4.5rem)';
                mainContent.style.transition = 'margin-left 0.3s ease, width 0.3s ease';
            }
        }
    }

    // Add hover effect to toggle button
    toggleButton.addEventListener('mouseover', () => {
        toggleButton.style.transform = 'scale(1.05)';
    });
    toggleButton.addEventListener('mouseout', () => {
        toggleButton.style.transform = 'scale(1)';
    });
});

async function handleLogout() {
    const confirmed = await window.confirmationDialog.show({
        title: 'Konfirmasi Keluar',
        message: 'Apakah Anda yakin ingin keluar?',
        type: 'logout',
        icon: 'logout'
    });
    
    if(confirmed) {
        window.location.href = '<?= site_url('auth/logout') ?>';
    }
}
</script>

<?php $this->load->view('dashboard/partials/confirmation_modal'); ?>

<style>
#sidebar {
    z-index: 9999 !important; 
}

#mainContent {
    transition: margin-left 0.3s ease, width 0.3s ease;
}

.confirmation-modal {
    z-index: 10000 !important;
}
</style>