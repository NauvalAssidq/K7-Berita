<?php $this->load->view('main/partials/header');?>

<main class="container mx-auto px-4 py-8 max-w-6xl">
    <article class="mb-12 border border-gray-200 rounded-xl transition-colors">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold mb-4 text-gray-900"><?= html_escape($news->title) ?></h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                <div class="flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full">
                    <i class="far fa-user text-sm"></i>
                    <span><?= html_escape($author) ?></span>
                </div>
                <div class="flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full">
                    <i class="far fa-clock text-sm"></i>
                    <span><?= date('d M Y', strtotime($news->created_at)) ?></span>
                </div>
                <?php if(isset($news->category_name)): ?>
                <div class="bg-blue-100 text-blue-600 px-3 py-1.5 rounded-full text-xs font-medium">
                    #<?= $news->category_name ?>
                </div>
                <?php endif; ?>
                <div class="flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full">
                    <form action="<?= site_url('main/vote/' . $news->id . '/up') ?>" method="POST" class="flex items-center">
                        <button type="submit" class="p-1 text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="far fa-thumbs-up"></i>
                        </button>
                    </form>
                    <span id="upvote-count" class="font-medium"><?= $news->upvotes ?></span>
                    <form action="<?= site_url('main/vote/' . $news->id . '/down') ?>" method="POST" class="flex items-center">
                        <button type="submit" class="p-1 text-gray-600 hover:text-red-600 transition-colors">
                            <i class="far fa-thumbs-down"></i>
                        </button>
                    </form>
                    <span id="downvote-count" class="font-medium"><?= $news->downvotes ?></span>
                </div>
                <div class="flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full">
                    <i class="far fa-comment"></i>
                    <span id="comment-count"><?= count($comments) ?></span>
                    <span>Komentar</span>
                </div>
            </div>
        </div>
        <div class="p-6 prose max-w-none border-b border-gray-200">
            <?= $news->content ?>
        </div>
        <div class="p-6 flex items-center gap-4 text-gray-500">
            <span class="font-medium text-sm">Bagikan:</span>
            <a href="#" class="hover:text-blue-600 transition-colors">
                <i class="fab fa-facebook-square text-lg"></i>
            </a>
            <a href="#" class="hover:text-blue-400 transition-colors">
                <i class="fab fa-twitter text-lg"></i>
            </a>
            <a href="#" class="hover:text-green-500 transition-colors">
                <i class="fab fa-whatsapp text-lg"></i>
            </a>
        </div>
    </article>
    <section class="mb-12 border border-gray-200 rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-6 text-gray-900">Tambahkan Komentar</h2>
        <form action="<?= site_url('main/add_comment/' . $news->id) ?>" method="POST">
            <textarea name="comment" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" placeholder="Tulis komentar Anda di sini..."></textarea>
            <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Kirim Komentar</button>
        </form>
    </section>
    <section class="border border-gray-200 rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-6 text-gray-900">
            Komentar (<span id="comment-count-display"><?= count($comments) ?></span>)
        </h2>
        <div id="comment-list" class="space-y-6">
            <?php if(!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                <div class="border-b border-gray-200 pb-6 last:border-0">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 text-blue-800 w-10 h-10 rounded-full flex items-center justify-center font-medium">
                            <?= strtoupper(substr($comment->user_name, 0, 1)) ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-baseline gap-3 mb-2">
                                <p class="font-medium text-gray-900"><?= html_escape($comment->user_name) ?></p>
                                <span class="text-gray-500 text-xs"><?= time_ago($comment->created_at) ?></span>
                            </div>
                            <p class="text-gray-700 text-sm leading-relaxed"><?= html_escape($comment->comment) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<style>
.prose {
    line-height: 1.75;
}
.prose img {
    border-radius: 0.5rem;
    margin: 1rem 0;
    max-width: 100%;
    height: auto;
    border: 1px solid #e5e7eb;
}
.prose iframe {
    width: 100%;
    border-radius: 0.5rem;
    margin: 1rem 0;
    border: 1px solid #e5e7eb;
}
</style>
