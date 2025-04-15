<?php $this->load->view('main/partials/header'); ?>
<main class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Hero Section -->
    <?php if(!empty($featured_news)): ?>
    <section class="mb-12 border-b border-gray-200 pb-8">
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Main Featured Article (Hero) -->
            <div class="md:col-span-2">
                <article class="border border-gray-200 rounded-xl overflow-hidden relative group">
                    <?php if(!empty($featured_news[0]->thumbnail)): ?>
                    <div class="relative aspect-[3/2]">
                        <img 
                            src="<?= $featured_news[0]->thumbnail ?>" 
                            alt="<?= html_escape($featured_news[0]->title) ?>" 
                            class="w-full h-full object-cover transform transition duration-500 group-hover:scale-105"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/20"></div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <div class="flex items-center gap-3 mb-4 text-sm">
                            <span class="bg-blue-600/90 backdrop-blur-sm px-4 py-1.5 rounded-full">
                                Berita Hangat
                            </span>
                            <span class="opacity-90"><?= date('d M Y', strtotime($featured_news[0]->created_at)) ?></span>
                        </div>
                        <h1 class="text-3xl font-bold mb-3 leading-tight">
                            <a href="<?= site_url('main/news/' . $featured_news[0]->slug) ?>" 
                               class="hover:opacity-90 transition-opacity">
                                <?= html_escape($featured_news[0]->title) ?>
                            </a>
                        </h1>
                        <div class="flex items-center gap-4 text-sm opacity-90">
                            <div class="flex items-center gap-2">
                                <i class="far fa-clock mr-1"></i>
                                <?= time_ago($featured_news[0]->created_at) ?>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="far fa-comment mr-1"></i>
                                <?= $featured_news[0]->comment_count ?> comments
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Berita Terkini Sidebar -->
            <div class="border-l border-gray-200 pl-6">
                <h2 class="text-lg font-semibold mb-6 pb-3 border-b border-gray-200">Berita Terkini</h2>
                
                <div class="space-y-5">
                    <?php foreach(array_slice($featured_news, 1) as $news): ?>
                    <article class="pb-5 border-b border-gray-200 last:border-0 last:pb-0">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span><?= date('d M Y', strtotime($news->created_at)) ?></span>
                                <span class="flex items-center gap-2">
                                    <i class="far fa-thumbs-up"></i><?= $news->upvotes ?>
                                </span>
                            </div>
                            
                            <h3 class="text-base font-medium leading-snug hover:text-blue-600 transition-colors">
                                <a href="<?= site_url('main/news/' . $news->slug) ?>">
                                    <?= html_escape($news->title) ?>
                                </a>
                            </h3>
                            
                            <?php if(isset($news->category_name)): ?>
                            <span class="text-xs text-blue-600 font-medium">
                                #<?= $news->category_name ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Category Tabs/Pills -->
    <div class="mb-8 overflow-x-auto scrollbar-hide">
        <div class="flex gap-2 pb-2">
            <a href="<?= site_url('main/') ?>" 
               class="px-4 py-2.5 rounded-full text-sm font-medium transition-all whitespace-nowrap
                      <?= !isset($current_category) ? 
                          'bg-blue-600 text-white shadow-sm' : 
                          'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>">
                Semua Kategori
            </a>
            
            <?php foreach($categories ?? [] as $category): ?>
            <a href="<?= site_url('main/category/' . $category->slug) ?>" 
               class="px-4 py-2.5 rounded-full text-sm font-medium transition-all whitespace-nowrap
                      <?= isset($current_category) && $current_category == $category->id ? 
                          'bg-blue-600 text-white shadow-sm' : 
                          'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>">
                <?= $category->name ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Main News List -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-8">Semua Berita</h2>
        
        <?php if(empty($news_list)): ?>
        <div class="bg-gray-50 p-8 rounded-xl text-center border border-gray-200">
            <p class="text-gray-600">Tidak ada berita ditemukan.</p>
        </div>
        <?php else: ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($news_list as $news): ?>
            <article class="border border-gray-200 rounded-xl hover:border-blue-300 transition-colors group">
                <?php if(!empty($news->thumbnail)): ?>
                <div class="aspect-video bg-gray-100 overflow-hidden rounded-t-xl">
                    <img 
                        src="<?= $news->thumbnail ?>" 
                        alt="<?= html_escape($news->title) ?>" 
                        class="w-full h-full object-cover transform transition duration-300 group-hover:scale-105"
                    >
                </div>
                <?php endif; ?>
                
                <div class="p-5">
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                        <span><?= date('d M Y', strtotime($news->created_at)) ?></span>
                        <?php if(isset($news->category_name)): ?>
                        <span class="text-blue-600 font-medium text-xs">
                            #<?= $news->category_name ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-3 hover:text-blue-600 transition-colors">
                        <a href="<?= site_url('main/news/' . $news->slug) ?>">
                            <?= html_escape($news->title) ?>
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        <?= strip_tags($news->content) ?>
                    </p>
                    
                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="far fa-thumbs-up"></i>
                                <?= $news->upvotes ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="far fa-comment"></i>
                                <?= $news->comment_count ?>
                            </span>
                        </div>
                        <a href="<?= site_url('main/news/' . $news->slug) ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                            Baca
                            <i class="fas fa-arrow-right text-xs mt-0.5"></i>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if(!empty($pagination)): ?>
        <div class="mt-8 border-t border-gray-200 pt-8">
            <div class="flex justify-center">
                <?= $pagination ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </section>
</main>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .aspect-[3/2] {
        aspect-ratio: 3 / 2;
    }
</style>