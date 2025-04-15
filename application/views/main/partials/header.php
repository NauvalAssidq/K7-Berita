<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | K7 Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        :root {
            --border-color: #e5e7eb;
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .nav-link {
            position: relative;
            padding-bottom: 4px;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Dropdown animations */
        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 200ms, transform 200ms;
        }
        .dropdown-exit {
            opacity: 1;
        }
        .dropdown-exit-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 200ms, transform 200ms;
        }

        .dropdown-scroll {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f3f4f6;
        }
        .dropdown-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .dropdown-scroll::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }
        .dropdown-scroll::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-white">
<?php 
  // Check if a valid profile image exists.
  $image_path = !empty($user->profile_image) ? FCPATH . $user->profile_image : '';
  $valid_image = (!empty($user->profile_image) && file_exists($image_path));
?>
<header class="sticky top-0 bg-white z-50 border-b border-[var(--border-color)] shadow-sm">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="<?= site_url() ?>" class="text-xl font-bold text-[var(--primary-color)] hover:opacity-90">K7 Berita</a>
            <nav class="hidden md:flex items-center gap-6">
                <a href="<?= site_url('main') ?>" class="nav-link text-gray-600 hover:text-[var(--primary-color)] transition-colors">Home</a>
                <a href="<?= site_url('about') ?>" class="nav-link text-gray-600 hover:text-[var(--primary-color)] transition-colors">Tentang</a>
                <a href="<?= site_url('contact') ?>" class="nav-link text-gray-600 hover:text-[var(--primary-color)] transition-colors">Kontak</a>
            </nav>
            <div class="flex items-center gap-4">
                <form action="<?= site_url('main/index') ?>" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari berita..." class="w-48 pl-4 pr-10 py-2 border border-[var(--border-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent" value="<?= html_escape($this->input->get('search')) ?>">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-[var(--primary-color)]">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <?php if ($this->session->userdata('logged_in')): ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 hover:opacity-90 focus:outline-none">
                            <?php if($valid_image): ?>
                                <img src="<?= htmlspecialchars(base_url($user->profile_image)) ?>" 
                                     class="h-9 w-9 rounded-full object-cover border-2 border-gray-200 shadow-sm"
                                     alt="<?= htmlspecialchars($user->full_name) ?>'s profile picture">
                            <?php else: ?>
                                <span class="bg-[var(--primary-color)] text-white w-8 h-8 rounded-full flex items-center justify-center font-medium">
                                    <?= strtoupper(substr($this->session->userdata('username'), 0, 1)) ?>
                                </span>
                            <?php endif; ?>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg overflow-hidden z-50 border border-gray-200"
                             style="display: none;">
                            <div class="py-1 dropdown-scroll max-h-96 overflow-y-auto">
                                <?php if ($this->session->userdata('role') != 'user'): ?>
                                    <a href="<?= site_url('dashboard') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors group">
                                        <i class="fas fa-chart-line text-gray-500 w-5 mr-3 group-hover:text-[var(--primary-color)]"></i> 
                                        Dashboard
                                    </a>
                                <?php endif; ?>
                                <a href="<?= site_url('profile') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors group">
                                    <i class="fas fa-user text-gray-500 w-5 mr-3 group-hover:text-[var(--primary-color)]"></i> 
                                    Profil Saya
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <a href="<?= site_url('auth/logout') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors group">
                                    <i class="fas fa-sign-out-alt text-gray-500 w-5 mr-3 group-hover:text-red-600"></i> 
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= site_url('auth/login') ?>" class="hidden md:block px-4 py-2 bg-[var(--primary-color)] text-white rounded-lg hover:bg-[var(--primary-hover)] transition-colors shadow-sm hover:shadow-md">Masuk</a>
                <?php endif; ?>
                <button id="mobile-menu-button" class="md:hidden p-2 text-gray-600 hover:text-[var(--primary-color)] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden py-4 border-t border-[var(--border-color)]">
            <div class="space-y-2">
                <nav class="space-y-1">
                    <a href="<?= site_url('main') ?>" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Home</a>
                    <a href="<?= site_url('about') ?>" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Tentang</a>
                    <a href="<?= site_url('contact') ?>" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Kontak</a>
                </nav>
                <?php if($this->session->userdata('logged_in')): ?>
                    <div class="pt-4 border-t border-[var(--border-color)] space-y-1">
                        <?php if ($this->session->userdata('role') != 'user'): ?>
                            <a href="<?= site_url('dashboard') ?>" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Dashboard</a>
                        <?php endif; ?>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Profil Saya</a>
                        <div class="border-t border-[var(--border-color)] my-2"></div>
                        <a href="<?= site_url('auth/logout') ?>" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="<?= site_url('auth/login') ?>" class="block mt-4 px-4 py-2 bg-[var(--primary-color)] text-white rounded-lg text-center hover:bg-[var(--primary-hover)] transition-colors shadow-sm hover:shadow-md">Masuk</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>
</body>
</html>
