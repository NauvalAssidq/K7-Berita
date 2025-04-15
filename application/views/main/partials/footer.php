<footer class="bg-gray-900 text-gray-300 mt-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Tentang -->
            <div class="space-y-4">
                <h3 class="text-white font-semibold mb-4">Tentang K7 Berita</h3>
                <p class="text-sm leading-relaxed">
                    Menyajikan berita teknologi terkini, ulasan produk, dan wawasan industri.
                    Dapatkan informasi terupdate seputar dunia teknologi digital.
                </p>
            </div>

            <!-- Berita Terbaru -->
            <div>
                <h3 class="text-white font-semibold mb-4">Berita Terbaru</h3>
                <ul class="space-y-2 text-sm">
                    <?php if(!empty($featured_news) && count($featured_news) > 0): ?>
                        <?php foreach(array_slice($featured_news, 0, 4) as $news): ?>
                            <li>
                                <a href="<?= site_url('main/news/'.$news->slug) ?>" class="hover:text-blue-400 transition-colors">
                                    <?= character_limiter($news->title, 35) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Belum ada berita terbaru</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Kategori -->
            <div>
                <h3 class="text-white font-semibold mb-4">Kategori</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= site_url('berita/kategori/teknologi') ?>" class="hover:text-blue-400 transition-colors">Teknologi</a></li>
                    <li><a href="<?= site_url('berita/kategori/ulasan') ?>" class="hover:text-blue-400 transition-colors">Ulasan</a></li>
                    <li><a href="<?= site_url('berita/kategori/wawasan') ?>" class="hover:text-blue-400 transition-colors">Wawasan</a></li>
                    <li><a href="<?= site_url('berita/kategori/panduan') ?>" class="hover:text-blue-400 transition-colors">Panduan</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-white font-semibold mb-4">Buletin</h3>
                <form action="<?= site_url('berlangganan') ?>" method="post" class="space-y-4">
                    <input type="email" name="email" placeholder="Masukkan email Anda" required
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg 
                                  focus:outline-none focus:border-blue-500">
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 
                                   transition-colors font-medium">
                        Berlangganan
                    </button>
                </form>
            </div>
        </div>

        <!-- Bagian Bawah -->
        <div class="border-t border-gray-800 mt-12 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex space-x-6 mb-4 md:mb-0">
                    <a href="https://twitter.com/k7berita" class="text-gray-400 hover:text-blue-400" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://github.com/k7berita" class="text-gray-400 hover:text-blue-400" aria-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://linkedin.com/company/k7berita" class="text-gray-400 hover:text-blue-400" aria-label="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
                <div class="text-sm text-gray-500 text-center md:text-right">
                    © <?= date('Y') ?> K7 Berita. Hak cipta dilindungi.<br>
                    <a href="<?= site_url('') ?>" class="hover:text-blue-400">Kembali ke Beranda</a> | 
                    <a href="<?= site_url('privasi') ?>" class="hover:text-blue-400">Privasi</a> | 
                    <a href="<?= site_url('syarat') ?>" class="hover:text-blue-400">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </div>
</footer>