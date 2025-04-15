<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Artikel - <?= CMS_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        /* Gaya kustom untuk Quill agar serasi dengan Filament */
        .ql-toolbar.ql-snow {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem 0.5rem 0 0;
            background: #f9fafb;
        }
        .ql-container.ql-snow {
            border: 1px solid #e5e7eb !important;
            border-top: 0 !important;
            border-radius: 0 0 0.5rem 0.5rem;
            min-height: 300px;
        }
        .ql-editor {
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
        }
    </style>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Buat Artikel</h1>
                    <p class="mt-1 text-sm text-gray-600">Tambahkan konten baru pada publikasi Anda</p>
                </div>
                <a href="<?= site_url('news'); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="material-icons-round text-sm">arrow_back</i>
                    <span class="text-sm">Kembali ke artikel</span>
                </a>
            </div>

            <!-- Pesan Error -->
            <?php if(isset($error) || isset($upload_errors)): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
                <i class="material-icons-round text-red-600">error</i>
                <div class="text-sm">
                    <?= $error ?? $upload_errors ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Kontainer Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <form action="<?= site_url('news/create'); ?>" method="post" enctype="multipart/form-data" class="p-6 space-y-6" id="news-form">
                    <!-- Judul -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                        <input type="text" id="title" name="title" value="<?= set_value('title'); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        <?= form_error('title', '<p class="text-red-600 text-xs mt-1">', '</p>'); ?>
                    </div>

                    <!-- Editor Konten -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Konten Artikel</label>
                        <div class="rounded-lg overflow-hidden">
                            <div id="editor-container"></div>
                        </div>
                        <input type="hidden" name="content" id="content">
                        <?= form_error('content', '<p class="text-red-600 text-xs mt-1">', '</p>'); ?>
                    </div>

                    <!-- Pilihan Kategori -->
                    <div class="space-y-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category_id" name="category_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Pilih Kategori</option>
                            <?php if(!empty($categories)): ?>
                                <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat->id; ?>" <?= set_select('category_id', $cat->id); ?>>
                                    <?= htmlspecialchars($cat->name); ?>
                                </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= form_error('category_id', '<p class="text-red-600 text-xs mt-1">', '</p>'); ?>
                    </div>

                    <!-- Toggle Terbit -->
                    <?php if (in_array($this->session->userdata('role'), [ROLE_ADMIN, ROLE_EDITOR])): ?>
                      <div class="flex items-center space-x-2">
                        <input type="checkbox" id="published" name="published" value="1" 
                              class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="published" class="text-sm font-medium text-gray-700">Terbitkan segera</label>
                      </div>
                    <?php endif; ?>

                    <!-- Aksi Form -->
                    <div class="pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <i class="material-icons-round text-sm">save</i>
                            Buat Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    // Inisialisasi editor Quill dengan toolbar bergaya Filament
    const quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Tulis konten artikel Anda di sini...',
        modules: {
            toolbar: {
                container: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ],
                handlers: {
                    image: imageHandler
                }
            }
        }
    });

    // Tangani pengiriman form
    document.getElementById('news-form').addEventListener('submit', function(e) {
        document.getElementById('content').value = quill.root.innerHTML;
    });

    // Penangan gambar dengan async/await
    async function imageHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = async () => {
            const file = input.files[0];

            if (file) {
                const resizedImage = await resizeImage(file, 800, 500); // Resize to 800x500
                const formData = new FormData();
                formData.append('image', resizedImage, file.name);

                try {
                    const response = await fetch('<?= site_url("news/upload_image"); ?>', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        const range = quill.getSelection();
                        quill.insertEmbed(range.index, 'image', result.url);
                    } else {
                        console.error('Gagal unggah:', result.error);
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        };
    }

    function resizeImage(file, width, height) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = event => {
                const img = new Image();
                img.src = event.target.result;

                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    canvas.width = width;
                    canvas.height = height;

                    // Use high-quality image smoothing
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';

                    // Calculate aspect ratio to avoid stretching
                    let scale = Math.max(width / img.width, height / img.height);
                    let newWidth = img.width * scale;
                    let newHeight = img.height * scale;

                    let xOffset = (width - newWidth) / 2;
                    let yOffset = (height - newHeight) / 2;

                    ctx.drawImage(img, xOffset, yOffset, newWidth, newHeight);

                    // Convert to Blob with higher quality (JPEG 90%)
                    canvas.toBlob(blob => {
                        resolve(blob);
                    }, 'image/jpeg', 0.9); // Adjust quality to 0.9 (90%)
                };
            };
            reader.onerror = error => reject(error);
        });
    }
</script>
</body>
</html>