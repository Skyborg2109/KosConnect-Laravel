<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Kos & Kamar - KosConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .pemilik-profile {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #334155;
        }

        .pemilik-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .pemilik-avatar:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .pemilik-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .pemilik-role {
            font-size: 12px;
            color: #94a3b8;
        }

        .menu {
            flex: 1;
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 25px;
        }

        .menu-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            border-left: none;
        }

        /* Notification Styles */
        .notification-wrapper {
            position: relative;
            margin-right: 15px;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            width: 320px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            z-index: 1000;
            border: 1px solid #e2e8f0;
            margin-top: 10px;
            overflow: hidden;
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .notification-dropdown.active {
            display: block;
        }

        .notification-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            color: #0f172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
        }

        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s;
            cursor: pointer;
            display: block;
            text-decoration: none;
            position: relative;
        }

        .notification-item:hover {
            background-color: #f8fafc;
        }

        /* Custom Scrollbar */
        .notification-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .notification-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .notification-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .notification-item.unread {
            background-color: #eff6ff;
            border-left: 3px solid #3b82f6;
        }
        
        .notification-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .notification-message {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-time {
            font-size: 11px;
            color: #94a3b8;
        }

        @keyframes activePulse {
            0%, 100% { box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 4px 20px rgba(59, 130, 246, 0.5); }
        }

        .menu-item i {
            margin-right: 25px;
            width: 20px;
        }

        .logout-btn {
            margin: 20px 15px;
            padding: 14px 20px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border: none;
            color: white;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            width: calc(100% - 30px);
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .logout-btn:hover::before {
            left: 100%;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }

        .logout-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-title {
            font-size: 14px;
            color: #64748b;
        }

        .header-icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .icon-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            border: none;
            transition: background-color 0.3s ease;
        }

        .icon-btn:hover {
            background-color: #2563eb;
        }



        /* Dashboard Content */
        .dashboard-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1e293b;
        }

        /* Kos Cards */
        .kos-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .kos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .kos-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
        }

        .kos-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .kos-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .kos-content {
            padding: 20px;
        }

        .kos-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .kos-name {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            flex: 1;
        }

        .kos-actions {
            display: flex;
            gap: 8px;
            margin-left: 12px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .action-btn.edit {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .action-btn.edit:hover {
            background-color: #bfdbfe;
            transform: scale(1.1);
        }

        .action-btn.delete {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .action-btn.delete:hover {
            background-color: #fecaca;
            transform: scale(1.1);
        }

        .kos-location {
            display: flex;
            align-items: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .kos-location i {
            margin-right: 8px;
            color: #3b82f6;
        }

        .kos-description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .kos-meta {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 13px;
        }

        .meta-item i {
            color: #7c3aed;
        }

        .kos-price {
            font-size: 22px;
            font-weight: 700;
            color: #7c3aed;
            margin-bottom: 16px;
        }

        .kos-price small {
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
        }

        .btn-kelola {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-kelola:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.aktif {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-badge.nonaktif {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 64px;
            color: #cbd5e1;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 24px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 2% auto; /* Reduced top margin to fit better */
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            max-height: 90vh; /* Limit height to 90% of viewport */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        /* Custom Scrollbar for Modal */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }
        .modal-content::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .modal-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .close {
            color: #64748b;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover {
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        a.btn {
            text-decoration: none;
        }

        .form-row {
            display: flex;
            gap: 16px;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .checkbox-label:hover {
            background-color: #f8fafc;
            border-color: #7c3aed;
        }

        .checkbox-label input[type="checkbox"] {
            cursor: pointer;
        }

        .checkbox-label span {
            font-size: 14px;
            color: #1e293b;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: #3b82f6;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                top: 12px;
                left: 12px;
                width: 40px;
                height: 40px;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                z-index: 1005;
                width: 280px;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                width: 100%;
            }

            .header {
                padding: 12px 15px 12px 65px;
                height: 64px;
            }

            .header-title h1 {
                font-size: 16px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 150px;
            }

            .dashboard-content {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 20px;
            }

            .kos-grid {
                grid-template-columns: 1fr;
            }

            .header-icons {
                gap: 8px;
            }

            .icon-btn {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .modal-content {
                width: 95%;
                margin: 5% auto;
                padding: 20px;
            }

            .checkbox-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 12px 12px 12px 60px;
            }

            .header-title h1 {
                font-size: 16px;
            }

            .dashboard-content {
                padding: 15px 10px;
            }

            .kos-card {
                margin: 0;
            }

            .kos-content {
                padding: 15px;
            }
        }

    </style>
    <script>
        function previewImages(input, containerId) {
            var container = document.getElementById(containerId);
            container.innerHTML = '';
            
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var div = document.createElement('div');
                        div.style.width = '80px';
                        div.style.height = '80px';
                        div.style.borderRadius = '8px';
                        div.style.overflow = 'hidden';
                        div.style.border = '1px solid #e2e8f0';
                        
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';
                        
                        div.appendChild(img);
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        function openAddKosModal() {
            document.getElementById('addKosModal').style.display = 'block';
        }

        function closeAddKosModal() {
            document.getElementById('addKosModal').style.display = 'none';
        }

        function openEditKosModal(id, nama, alamat, kota, provinsi, harga, deskripsi, jenis, fasilitas) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_kos').value = nama;
            document.getElementById('edit_jenis_kos').value = jenis;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_kota').value = kota;
            document.getElementById('edit_provinsi').value = provinsi;
            document.getElementById('edit_harga_dasar').value = harga;
            document.getElementById('edit_deskripsi').value = deskripsi;
            
            // Handle facilities checkboxes
            const checkboxes = document.querySelectorAll('.edit-fasilitas');
            let facilitiesArray = [];
            
            if (fasilitas) {
                if (Array.isArray(fasilitas)) {
                    facilitiesArray = fasilitas;
                } else if (typeof fasilitas === 'string') {
                    // Handle comma separated string if any
                    facilitiesArray = fasilitas.split(',').map(item => item.trim());
                }
            }

            checkboxes.forEach(cb => {
                cb.checked = false; // Reset first
                if (facilitiesArray.includes(cb.value)) {
                    cb.checked = true;
                }
            });

            document.getElementById('editKosModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editKosModal').style.display = 'none';
        }

        function deleteKos(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data kos akan dihapus permanen! Semua data kamar dan booking terkait juga akan terhapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.action = '/pemilik/delete-kos/' + id;
                    form.method = 'POST';
                    
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                    
                    var methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addKosModal');
            const editModal = document.getElementById('editKosModal');
            if (event.target == addModal) {
                addModal.style.display = 'none';
            }
            if (event.target == editModal) {
                editModal.style.display = 'none';
            }
        }

        function toggleMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleMobileMenu();
                }
            });
        });
    </script>
</head>
<body>
    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="pemilik-profile">
                <div class="pemilik-avatar" style="overflow: hidden;">
                    @if(session('user.foto_profil'))
                        <img src="{{ session('user.foto_profil') }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="pemilik-name">Pemilik Kos</div>
                <div class="pemilik-role">Status:<br>Pemilik</div>
            </div>

            <div class="menu">
                <a href="/dashboard-pemilik" class="menu-item">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/pemilik/manajemen-kos" class="menu-item active">
                    <i class="fas fa-building"></i>
                    <span>Manajemen Kos</span>
                </a>
                <a href="/pemilik/verifikasi-pembayaran" class="menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Verifikasi Pembayaran</span>
                </a>
                <a href="/pemilik/kelola-pesanan" class="menu-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Kelola Pesanan</span>
                </a>
                <a href="/pemilik/keluhan-kos" class="menu-item">
                    <i class="fas fa-comments"></i>
                    <span>Keluhan Kos</span>
                </a>

                <a href="/profil-pemilik" class="menu-item">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil Saya</span>
                </a>
            </div>

            <form method="POST" action="/logout-pemilik" style="display: inline;">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout(this.form)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-title">
                    <h1>Manajemen Kos</h1></div>
                <div class="header-icons">
                    <form method="GET" action="/profil-pemilik" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-user"></i>
                        </button>
                    </form>
                    <!-- Notification Dropdown -->
                    <div class="notification-wrapper">
                        <button class="icon-btn notification" id="notificationBtn" onclick="toggleNotifications()" style="border: none;">
                            <i class="fas fa-bell"></i>
                            @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
                            @endif
                        </button>
                        <div class="notification-dropdown" id="notificationDropdown">
                            <div class="notification-header">
                                <span>Notifikasi</span>
                                <small>{{ $unreadNotificationsCount ?? 0 }} Baru</small>
                            </div>
                            <div class="notification-list">
                                @if(isset($notifications) && count($notifications) > 0)
                                    @foreach($notifications as $notif)
                                        <a href="{{ $notif->link ?? '#' }}" class="notification-item {{ !$notif->is_read ? 'unread' : '' }}">
                                            <div class="notification-title">{{ $notif->judul }}</div>
                                            <div class="notification-message">{{ $notif->pesan }}</div>
                                            <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="empty-notification" style="padding: 20px; text-align: center; color: #94a3b8;">
                                        Tidak ada notifikasi
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">


                <!-- Kos Section -->
                <div class="kos-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 class="section-title">Daftar Kos Saya</h2>
                        <button onclick="openAddKosModal()" class="btn-primary" type="button">
                            <i class="fas fa-plus"></i> Tambah Kos Baru
                        </button>
                    </div>
                    
                    @if($kos->count() > 0)
                        <div class="kos-grid">
                            @foreach($kos as $item)
                            <div class="kos-card">
                                @if($item->gambar_url)
                                    <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_kos }}" class="kos-image">
                                @else
                                    <div class="kos-image" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);">
                                        <i class="fas fa-building" style="font-size: 48px; color: #94a3b8;"></i>
                                    </div>
                                @endif
                                
                                <div class="kos-content">
                                    <div class="kos-header">
                                        <h3 class="kos-name">{{ $item->nama_kos }}</h3>
                                        <div class="kos-actions">
                                            <button type="button" class="action-btn edit" title="Edit Kos"
                                                onclick="openEditKosModal({{ $item->id }}, '{{ addslashes($item->nama_kos) }}', '{{ addslashes($item->alamat) }}', '{{ $item->kota }}', '{{ $item->provinsi }}', '{{ intval($item->harga_dasar) }}', '{{ addslashes($item->deskripsi) }}', '{{ $item->jenis_kos }}', {{ json_encode($item->fasilitas ?: []) }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="action-btn delete" title="Hapus Kos" onclick="deleteKos({{ $item->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="kos-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $item->alamat }}, {{ $item->kota }}
                                    </div>
                                    
                                    @if($item->deskripsi)
                                        <p class="kos-description">{{ Str::limit($item->deskripsi, 100) }}</p>
                                    @endif
                                    
                                    <div class="kos-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-door-open"></i>
                                            <span>{{ $item->kamar->count() }} Kamar</span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="status-badge {{ $item->status }}">{{ ucfirst($item->status) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="kos-price">
                                        Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}
                                        <small>/bulan</small>
                                    </div>
                                    
                                    <a href="/pemilik/manajemen-kamar/{{ $item->id }}" class="btn-kelola">
                                        <i class="fas fa-cog"></i> Kelola Kamar
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-building"></i>
                            <h3>Belum Ada Kos</h3>
                            <p>Anda belum memiliki kos yang terdaftar. Mulai tambahkan kos pertama Anda!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Kos Modal -->
    <div id="addKosModal" class="modal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h2 class="modal-title"><i class="fas fa-plus-circle"></i> Tambah Kos Baru</h2>
                <span class="close" onclick="closeAddKosModal()">&times;</span>
            </div>
            <form method="POST" action="/pemilik/store-kos" enctype="multipart/form-data">
                @csrf
                
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="nama_kos">
                            <i class="fas fa-building"></i> Nama Kos
                        </label>
                        <input type="text" id="nama_kos" name="nama_kos" class="form-input" placeholder="Masukkan nama kos" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="jenis_kos">
                            <i class="fas fa-venus-mars"></i> Tipe Kos
                        </label>
                        <select id="jenis_kos" name="jenis_kos" class="form-input" required>
                            <option value="campuran">Campuran</option>
                            <option value="putra">Putra</option>
                            <option value="putri">Putri</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="alamat">
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </label>
                    <textarea id="alamat" name="alamat" class="form-input" rows="3" placeholder="Masukkan alamat lengkap kos" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="kota">
                            <i class="fas fa-city"></i> Kota
                        </label>
                        <input type="text" id="kota" name="kota" class="form-input" placeholder="Contoh: Jakarta" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="provinsi">
                            <i class="fas fa-map"></i> Provinsi
                        </label>
                        <input type="text" id="provinsi" name="provinsi" class="form-input" placeholder="Contoh: DKI Jakarta" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="harga_dasar">
                            <i class="fas fa-money-bill-wave"></i> Harga per Bulan (Rp)
                        </label>
                        <input type="number" id="harga_dasar" name="harga_dasar" class="form-input" placeholder="cth: 800000" required min="0">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="jumlah_kamar">
                            <i class="fas fa-door-open"></i> Jumlah Kamar
                        </label>
                        <input type="number" id="jumlah_kamar" name="jumlah_kamar" class="form-input" placeholder="cth: 20" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi">
                        <i class="fas fa-align-left"></i> Deskripsi
                    </label>
                    <textarea id="deskripsi" name="deskripsi" class="form-input" rows="3" placeholder="Tulis deskripsi singkat kos"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-check-square"></i> Fasilitas
                    </label>
                    <div class="checkbox-grid">
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="WiFi">
                            <span>WiFi</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="AC">
                            <span>AC</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="KM Dalam">
                            <span>KM Dalam</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="Parkir">
                            <span>Parkir</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="Kasur">
                            <span>Kasur</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="Meja">
                            <span>Meja</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-images"></i> Foto Kos
                    </label>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                         <!-- 1. Utama -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                1. Gambar Utama (Cover)
                            </label>
                            <input type="file" name="gambar_utama" class="form-input" accept="image/*" onchange="previewImages(this, 'preview-utama')">
                            <div id="preview-utama" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                        <!-- 2. Bangunan -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                2. Foto Bangunan (Tampak Depan/Luar)
                            </label>
                            <input type="file" name="gambar_bangunan[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'preview-bangunan')">
                            <div id="preview-bangunan" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                        <!-- 3. Fasilitas -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                3. Foto Fasilitas Bersama (Dapur, Parkir, Dll)
                            </label>
                            <input type="file" name="gambar_fasilitas[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'preview-fasilitas')">
                            <div id="preview-fasilitas" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>
                        
                         <!-- 4. Kamar -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                4. Foto Kamar
                            </label>
                            <input type="file" name="gambar_kamar[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'preview-kamar')">
                            <div id="preview-kamar" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                         <!-- 5. Kamar Mandi -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                5. Foto Kamar Mandi
                            </label>
                            <input type="file" name="gambar_kamar_mandi[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'preview-kamar-mandi')">
                            <div id="preview-kamar-mandi" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                         <!-- 6. Lainnya -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                6. Foto Lainnya
                            </label>
                            <input type="file" name="gambar_lainnya[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'preview-lainnya')">
                            <div id="preview-lainnya" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeAddKosModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Simpan Kos Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Kos Modal -->
    <div id="editKosModal" class="modal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h2 class="modal-title"><i class="fas fa-edit"></i> Edit Kos</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editKosForm" method="POST" action="/pemilik/update-kos" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="edit_nama_kos">
                            <i class="fas fa-building"></i> Nama Kos
                        </label>
                        <input type="text" id="edit_nama_kos" name="nama_kos" class="form-input" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_jenis_kos">
                            <i class="fas fa-venus-mars"></i> Tipe Kos
                        </label>
                        <select id="edit_jenis_kos" name="jenis_kos" class="form-input" required>
                            <option value="campuran">Campuran</option>
                            <option value="putra">Putra</option>
                            <option value="putri">Putri</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_alamat">
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </label>
                    <textarea id="edit_alamat" name="alamat" class="form-input" rows="3" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_kota">
                            <i class="fas fa-city"></i> Kota
                        </label>
                        <input type="text" id="edit_kota" name="kota" class="form-input" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_provinsi">
                            <i class="fas fa-map"></i> Provinsi
                        </label>
                        <input type="text" id="edit_provinsi" name="provinsi" class="form-input" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_harga_dasar">
                        <i class="fas fa-money-bill-wave"></i> Harga per Bulan (Rp)
                    </label>
                    <input type="number" id="edit_harga_dasar" name="harga_dasar" class="form-input" required min="0">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_deskripsi">
                        <i class="fas fa-align-left"></i> Deskripsi
                    </label>
                    <textarea id="edit_deskripsi" name="deskripsi" class="form-input" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-check-square"></i> Fasilitas
                    </label>
                    <div class="checkbox-grid">
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="WiFi" class="edit-fasilitas">
                            <span>WiFi</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="AC" class="edit-fasilitas">
                            <span>AC</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="KM Dalam" class="edit-fasilitas">
                            <span>KM Dalam</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="Parkir" class="edit-fasilitas">
                            <span>Parkir</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="Kasur" class="edit-fasilitas">
                            <span>Kasur</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="fasilitas[]" value="Meja" class="edit-fasilitas">
                            <span>Meja</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-images"></i> Ganti/Tambah Foto Kos
                    </label>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                         <!-- 1. Utama -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                1. Ganti Gambar Utama (Cover)
                            </label>
                            <input type="file" name="gambar_utama" class="form-input" accept="image/*" onchange="previewImages(this, 'edit-preview-utama')">
                            <div id="edit-preview-utama" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                        <!-- 2. Bangunan -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                2. Tambah Foto Bangunan
                            </label>
                            <input type="file" name="gambar_bangunan[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'edit-preview-bangunan')">
                            <div id="edit-preview-bangunan" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                        <!-- 3. Fasilitas -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                3. Tambah Foto Fasilitas Bersama
                            </label>
                            <input type="file" name="gambar_fasilitas[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'edit-preview-fasilitas')">
                            <div id="edit-preview-fasilitas" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>
                        
                         <!-- 4. Kamar -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                4. Tambah Foto Kamar (Contoh)
                            </label>
                            <input type="file" name="gambar_kamar[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'edit-preview-kamar')">
                            <div id="edit-preview-kamar" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                         <!-- 5. Kamar Mandi -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                5. Tambah Foto Kamar Mandi
                            </label>
                            <input type="file" name="gambar_kamar_mandi[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'edit-preview-kamar-mandi')">
                            <div id="edit-preview-kamar-mandi" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>

                         <!-- 6. Lainnya -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">
                                6. Tambah Foto Lainnya
                            </label>
                            <input type="file" name="gambar_lainnya[]" class="form-input" multiple accept="image/*" onchange="previewImages(this, 'edit-preview-lainnya')">
                            <div id="edit-preview-lainnya" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeEditModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('components.sweetalert')
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            const badge = document.querySelector('.notification-badge');
            
            if (!dropdown.classList.contains('active')) {
                fetch('/pemilik/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok && badge) badge.style.display = 'none';
                });
            }
            dropdown.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const wrapper = document.querySelector('.notification-wrapper');
            const dropdown = document.getElementById('notificationDropdown');
            const btn = document.getElementById('notificationBtn');
            
            if (wrapper && !wrapper.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
</body>
</html>
