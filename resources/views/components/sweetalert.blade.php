<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Success Message
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        // Error Message
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        // Validation Errors
        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: "Terjadi kesalahan validasi. Silakan periksa input Anda."
            });
        @endif

        // Global Confirmation for Links/Buttons
        // Usage: Add class 'btn-confirm-delete' or 'btn-confirm-action' 
        // Optional attributes: data-title, data-text, data-confirm-text
        
        // Form Submission Confirmation (e.g. Delete forms)
        document.querySelectorAll('form').forEach(form => {
            if (form.classList.contains('form-confirm-delete')) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }
            
            // Generic Action Confirmation
            if (form.classList.contains('form-confirm-action')) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const title = this.getAttribute('data-title') || 'Konfirmasi Aksi';
                    const text = this.getAttribute('data-text') || 'Apakah Anda yakin ingin melanjutkan?';
                    const confirmText = this.getAttribute('data-confirm-text') || 'Ya, Lanjutkan';
                    const confirmColor = this.getAttribute('data-confirm-color') || '#3085d6';

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: confirmColor,
                        cancelButtonColor: '#d33',
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }

             // Booking Confirmation
             if (form.classList.contains('form-confirm-booking')) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Booking',
                        text: "Apakah Anda yakin ingin memesan kamar ini? Pastikan data sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Pesan Sekarang',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }
        });
        
        // Link Click Confirmation (e.g. Logout links that are improperly done as GET, though they should be POST)
        // Or simple action links
        document.querySelectorAll('.btn-confirm-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan diarahkan ke halaman lain.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    });

    // Global Logout Confirmation function
    function confirmLogout(form) {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: "Apakah Anda yakin ingin keluar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
