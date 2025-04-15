<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - <?php echo CMS_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full font-['Inter'] antialiased">
<div class="flex h-screen">
    <?php $this->load->view('dashboard/partials/sidebar'); ?>

        <main id="mainContent" style="width: calc(100% - 4.5rem); margin-left: 4.5rem;" class="transition-all duration-300">
        <?php $this->load->view('dashboard/partials/header'); ?>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900"><?php echo $title; ?></h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Selamat datang kembali, <span class="font-medium text-blue-600"><?php echo $username; ?></span>
                        </p>
                    </div>
                </div>

                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <!-- Total Berita -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Total Berita</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo $total_news; ?></p>
                            </div>
                            <div class="p-2 bg-blue-100/50 rounded-lg">
                                <i class="material-icons-round text-lg text-blue-600">article</i>
                            </div>
                        </div>
                    </div>

                    <!-- Berita Terbit -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Terbit</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo $published_news; ?></p>
                            </div>
                            <div class="p-2 bg-green-100/50 rounded-lg">
                                <i class="material-icons-round text-lg text-green-600">check_circle</i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pengguna -->
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Total Pengguna</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo $total_users; ?></p>
                            </div>
                            <div class="p-2 bg-purple-100/50 rounded-lg">
                                <i class="material-icons-round text-lg text-purple-600">people</i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Pertumbuhan Pengguna -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-medium text-gray-900">Pertumbuhan Pengguna</h3>
                        <span class="text-sm text-gray-500">7 hari terakhir</span>
                    </div>
                    <div class="relative" style="height: 200px;">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>

                <!-- Artikel Terbaru -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-base font-medium text-gray-900">Artikel Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if (!empty($news_snippet)): ?>
                                    <?php foreach ($news_snippet as $news): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 text-sm text-gray-900"><?php echo $news->title; ?></td>
                                            <td class="px-4 py-3 text-right">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?php echo $news->published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'; ?>">
                                                    <?php echo $news->published ? 'Terbit' : 'Draft'; ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right text-sm text-gray-500"><?php echo date('M d, Y', strtotime($news->created_at)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500">Tidak ada artikel yang ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div>
        </main>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $user_growth_labels; ?>,
            datasets: [{
                label: 'Pengguna Baru',
                data: <?php echo $user_growth_counts; ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                borderWidth: 2,
                pointRadius: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: { 
                        stepSize: 1,
                        color: '#6b7280'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#6b7280' }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
</body>
</html>
