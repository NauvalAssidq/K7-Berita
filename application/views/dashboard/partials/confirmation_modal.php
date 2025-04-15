<div id="confirmation-modal" 
     class="fixed inset-0 bg-black bg-opacity-30 z-[999] hidden"
     aria-modal="true"
     role="dialog"
     aria-labelledby="confirmation-modal-title"
     aria-describedby="confirmation-modal-description">
     
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 transition-all">
            <!-- Kontainer Ikon -->
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="material-icons-round text-red-600 text-xl" id="confirmation-icon">warning</i>
                </div>
                <div>
                    <h3 id="confirmation-modal-title" class="text-lg font-medium text-gray-900">
                        <!-- Judul akan dimasukkan di sini -->
                    </h3>
                    <p id="confirmation-modal-description" class="text-sm text-gray-500 mt-1">
                        <!-- Pesan akan dimasukkan di sini -->
                    </p>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" 
                        data-action="cancel"
                        class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="button" 
                        data-action="confirm"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
class ConfirmationDialog {
    constructor() {
        this.modal = document.getElementById('confirmation-modal');
        this.title = document.getElementById('confirmation-modal-title');
        this.description = document.getElementById('confirmation-modal-description');
        this.icon = document.getElementById('confirmation-icon');
        this.confirmButton = this.modal.querySelector('[data-action="confirm"]');
        this.cancelButton = this.modal.querySelector('[data-action="cancel"]');

        this.initialize();
    }

    initialize() {
        // Penanganan klik
        this.cancelButton.addEventListener('click', () => this.hide());
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.hide();
        });

        // Kontrol keyboard
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.hide();
        });
    }

    show(options = {}) {
        const actionConfig = {
            logout: { icon: 'logout', text: 'Keluar', color: 'red' },
            bulk_delete: { icon: 'delete_forever', text: 'Hapus Semua', color: 'red' },
            single_delete: { icon: 'delete', text: 'Hapus', color: 'red' },
            save: { icon: 'save', text: 'Simpan Perubahan', color: 'blue' }
        };

        const { icon = 'warning', title = 'Anda yakin?', message = 'Tindakan ini tidak dapat dibatalkan.', type } = options;
        const action = actionConfig[type] || { icon, text: 'Konfirmasi', color: 'blue' };

        // Atur konten modal
        this.icon.textContent = action.icon;
        this.title.textContent = title;
        this.description.textContent = message;
        this.confirmButton.textContent = action.text;

        // Reset kelas warna sebelum menerapkan yang baru
        this.resetClasses();

        // Terapkan kelas warna baru
        this.icon.parentElement.classList.add(`bg-${action.color}-100`);
        this.icon.classList.add(`text-${action.color}-600`);
        this.confirmButton.classList.add(`bg-${action.color}-600`, `hover:bg-${action.color}-700`);

        // Tampilkan modal
        this.modal.classList.remove('hidden');
        this.confirmButton.focus();

        return new Promise((resolve) => {
            this.confirmButton.onclick = () => {
                this.hide();
                resolve(true);
            };
        });
    }

    hide() {
        this.modal.classList.add('hidden');
        this.resetClasses();
    }

    resetClasses() {
        // Hapus kelas warna sebelumnya
        ['red', 'blue'].forEach(color => {
            this.icon.parentElement.classList.remove(`bg-${color}-100`);
            this.icon.classList.remove(`text-${color}-600`);
            this.confirmButton.classList.remove(`bg-${color}-600`, `hover:bg-${color}-700`);
        });
    }
}

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    window.confirmationDialog = new ConfirmationDialog();
});
</script>
