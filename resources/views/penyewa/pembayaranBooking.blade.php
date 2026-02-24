<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran {{ $booking->kamar->kos->nama_kos }} - KosConnect</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* == CSS RESET & DASAR == */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .modal-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            max-width: 650px;
            width: 100%;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .modal-header {
            padding: 20px 32px;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h3 {
            font-size: 20px;
            font-weight: 700;
            color: #212529;
        }
        .modal-header .close-btn {
            font-size: 24px;
            color: #6c757d;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.2s;
            text-decoration: none;
        }
        .modal-header .close-btn:hover {
            color: #dc3545;
        }

        .modal-body {
            padding: 32px;
            background: #fff;
            max-height: 80vh;
            overflow-y: auto;
        }
        .modal-body h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #0d6efd;
        }

        .booking-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 32px;
            border: 1px solid #e9ecef;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #495057;
            font-size: 14px;
        }
        .summary-row strong {
            text-align: right;
            color: #212529;
            font-weight: 600;
            flex: 1;
            margin-left: 20px;
        }
        .summary-row.total {
            border-top: 1px solid #e9ecef;
            padding-top: 14px;
            margin-top: 14px;
            font-size: 16px;
        }
        .summary-row.total strong {
            color: #0d6efd;
            font-size: 20px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 32px;
        }
        .payment-option {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            cursor: pointer;
            background: #ffffff;
            transition: all 0.2s;
        }
        .payment-option:hover {
            background-color: #f8f9fa;
        }
        .payment-option.selected {
            border-color: #0d6efd;
            background-color: #f0f7ff;
            box-shadow: 0 0 0 2px rgba(13,110,253,0.1);
        }
        .payment-option .icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        
        .payment-option .icon-wrapper.blue { background-color: #dbeafe; color: #2563eb; }
        .payment-option .icon-wrapper.green { background-color: #d1fae5; color: #059669; }
        .payment-option .icon-wrapper.purple { background-color: #ede9fe; color: #7c3aed; }
        .payment-option .icon-wrapper.yellow { background-color: #fef9c3; color: #d97706; }

        .payment-option .info strong {
            font-size: 14px;
            font-weight: 600;
            color: #212529;
            display: block;
        }
        .payment-option .info span {
            font-size: 12px;
            color: #6c757d;
        }

        /* Bank Detail View */
        .payment-details-container {
            display: none;
            background: #f0f7ff;
            border: 1px solid #0d6efd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 24px;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .payment-details-header {
            font-size: 14px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bank-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed #cbd5e1;
        }

        .bank-info-item:last-child {
            border-bottom: none;
        }

        .bank-info-label {
            font-size: 13px;
            color: #64748b;
        }

        .bank-info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .copy-badge {
            font-size: 10px;
            background: #dbeafe;
            color: #2563eb;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 8px;
            cursor: pointer;
        }

        .upload-section {
            margin-bottom: 24px;
        }
        
        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: border-color 0.2s;
            position: relative;
        }
        .upload-box:hover {
            border-color: #0d6efd;
        }
        .upload-box.has-file {
            border-color: #198754;
            background-color: #f0fdf4;
            border-style: solid;
        }
        .upload-box i {
            font-size: 32px;
            color: #adb5bd;
            margin-bottom: 10px;
            display: block;
        }
        .upload-box .preview-image {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            display: none;
            border-radius: 4px;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .modal-footer {
            padding: 20px 32px;
            border-top: 1px solid #e9ecef;
            background-color: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            gap: 14px;
        }
        
        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-batal {
            background-color: #e9ecef;
            color: #495057;
        }
        .btn-batal:hover {
            background-color: #dee2e6;
        }
        .btn-konfirmasi {
            background-color: #0d6efd;
            color: #fff;
        }
        .btn-konfirmasi:hover {
            background-color: #0b5ed7;
            transform: translateY(-1px);
        }
        .btn-konfirmasi:disabled {
            background-color: #a0c3ff;
            cursor: not-allowed;
            transform: none;
        }

        /* == MOBILE RESPONSIVE == */
        @media (max-width: 600px) {
            body {
                padding: 10px;
                align-items: flex-start;
            }
            .modal-container {
                border-radius: 16px;
                box-shadow: none;
                margin-top: 10px;
            }
            .modal-header {
                padding: 16px 20px;
            }
            .modal-body {
                padding: 20px;
            }
            .booking-summary {
                padding: 16px;
                margin-bottom: 24px;
                border: none;
                background-color: #f1f5f9;
            }
            .summary-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                margin-bottom: 15px;
            }
            .summary-row span {
                min-width: unset;
                font-size: 12px;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .summary-row strong {
                text-align: left;
                margin-left: 0;
                font-size: 15px;
            }
            .summary-row.total {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding-top: 15px;
                margin-top: 5px;
            }
            .summary-row.total span {
                font-size: 14px;
                text-transform: none;
                color: #1e293b;
                font-weight: 600;
            }
            .summary-row.total strong {
                text-align: right;
                font-size: 18px;
            }
            .payment-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .modal-footer {
                padding: 16px 20px;
                flex-direction: column-reverse;
            }
            .btn {
                width: 100%;
                padding: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="modal-container">
        
        <div class="modal-header">
            <h3><i class="fas fa-wallet" style="margin-right: 10px; color: #0d6efd;"></i> Pembayaran Booking</h3>
            <a href="/dashboard-penyewa" class="close-btn">&times;</a>
        </div>
        
        <form action="/store-pembayaran" method="POST" enctype="multipart/form-data" id="paymentForm">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <input type="hidden" name="jumlah" value="{{ $booking->total_harga }}">
            <input type="hidden" name="metode_pembayaran" id="metode_pembayaran_input" required>
            <input type="hidden" name="tanggal_bayar" value="{{ date('Y-m-d') }}">

            <div class="modal-body">
                
                <h4>Ringkasan Pesanan</h4>
                <div class="booking-summary">
                    <div class="summary-row">
                        <span>Nama Kos</span>
                        <strong>{{ $booking->kamar->kos->nama_kos }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Kamar</span>
                        <strong>Kamar {{ $booking->kamar->nomor_kamar }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Alamat</span>
                        <strong>{{ $booking->kamar->kos->alamat }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Durasi</span>
                        <strong>{{ $booking->durasi_bulan }} Bulan</strong>
                    </div>
                    <div class="summary-row">
                        <span>Tanggal Mulai</span>
                        <strong>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</strong>
                    </div>
                    <div class="summary-row total">
                        <span>Total Pembayaran</span>
                        <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong>
                    </div>
                </div>
                
                <h4>Pilih Metode Pembayaran <span style="color:red">*</span></h4>
                <div class="payment-grid">
                    
                    <div class="payment-option" onclick="selectPayment(this, 'Transfer Bank')">
                        <div class="icon-wrapper blue">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="info">
                            <strong>Transfer Bank</strong>
                            <span>BCA, Mandiri, BNI, BRI</span>
                        </div>
                    </div>
                    
                    <div class="payment-option" onclick="selectPayment(this, 'E-Wallet')">
                        <div class="icon-wrapper green">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="info">
                            <strong>E-Wallet</strong>
                            <span>GoPay, OVO, DANA, LinkAja</span>
                        </div>
                    </div>
                    
                    <div class="payment-option" onclick="selectPayment(this, 'Virtual Account')">
                        <div class="icon-wrapper purple">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="info">
                            <strong>Virtual Account</strong>
                            <span>Bayar Otomatis (VA)</span>
                        </div>
                    </div>
                    
                    <div class="payment-option" onclick="selectPayment(this, 'Kartu Kredit')">
                        <div class="icon-wrapper yellow">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="info">
                            <strong>Kartu Kredit</strong>
                            <span>VISA, Mastercard</span>
                        </div>
                    </div>
                </div>

                <div id="payment-details" class="payment-details-container">
                    <div class="payment-details-header">
                        <i class="fas fa-info-circle"></i>
                        <span id="details-title">Detail Transfer</span>
                    </div>
                    <div id="details-content">
                        <!-- Dynamic Content -->
                    </div>
                </div>
                <div id="payment-error" class="error-message">Silakan pilih metode pembayaran terlebih dahulu</div>
                
                <h4>Upload Bukti Pembayaran <span style="color:red">*</span></h4>
                <div class="upload-section">
                    <div class="upload-box" onclick="document.getElementById('file-upload').click()">
                        <i class="fas fa-cloud-upload-alt" id="upload-icon"></i>
                        <span class="text-main" id="upload-text">Klik untuk upload bukti transfer</span>
                        <span class="text-secondary" id="upload-subtext">JPG, PNG, PDF (Max. 2MB)</span>
                        <img id="preview" class="preview-image">
                    </div>
                    <input type="file" name="bukti_transfer" id="file-upload" style="display: none" accept="image/*,.pdf" onchange="previewFile(this)" required>
                    @error('bukti_transfer')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
            
            <div class="modal-footer">
                <a href="/dashboard-penyewa" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-konfirmasi" id="submit-btn">Konfirmasi Pembayaran</button>
            </div>
        </form>
        
    </div>
    
    <script>
        function selectPayment(element, method) {
            // Remove selected class from all options
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            element.classList.add('selected');
            
            // Set hidden input value
            document.getElementById('metode_pembayaran_input').value = method;
            document.getElementById('payment-error').style.display = 'none';

            // Show Bank Details
            const detailsContainer = document.getElementById('payment-details');
            const detailsContent = document.getElementById('details-content');
            const detailsTitle = document.getElementById('details-title');
            
            detailsContainer.style.display = 'block';
            
            let html = '';
            if (method === 'Transfer Bank') {
                detailsTitle.textContent = 'Detail Transfer Bank';
                html = `
                    <div class="bank-info-item">
                        <span class="bank-info-label">Bank BCA</span>
                        <span class="bank-info-value">1234567890 <span class="copy-badge">Salin</span></span>
                    </div>
                    <div class="bank-info-item">
                        <span class="bank-info-label">Bank Mandiri</span>
                        <span class="bank-info-value">9876543210 <span class="copy-badge">Salin</span></span>
                    </div>
                    <div class="bank-info-item">
                        <span class="bank-info-label">Atas Nama</span>
                        <span class="bank-info-value">Admin KosConnect</span>
                    </div>
                `;
            } else if (method === 'E-Wallet') {
                detailsTitle.textContent = 'Detail E-Wallet';
                html = `
                    <div class="bank-info-item">
                        <span class="bank-info-label">GoPay/OVO/DANA</span>
                        <span class="bank-info-value">0812-3456-7890 <span class="copy-badge">Salin</span></span>
                    </div>
                    <div class="bank-info-item">
                        <span class="bank-info-label">Atas Nama</span>
                        <span class="bank-info-value">KosConnect Merchant</span>
                    </div>
                `;
            } else if (method === 'Virtual Account') {
                detailsTitle.textContent = 'Detail Virtual Account';
                html = `
                    <div class="bank-info-item">
                        <span class="bank-info-label">VA Number</span>
                        <span class="bank-info-value">880123456789 <span class="copy-badge">Salin</span></span>
                    </div>
                    <div class="bank-info-item">
                        <span class="bank-info-label">Provider</span>
                        <span class="bank-info-value">BCA Virtual Account</span>
                    </div>
                `;
            } else {
                detailsTitle.textContent = 'Detail Pembayaran';
                html = `
                    <div class="bank-info-item">
                        <span class="bank-info-label">Metode</span>
                        <span class="bank-info-value">${method}</span>
                    </div>
                    <div class="bank-info-item" style="color: #64748b; font-size: 13px; font-style: italic;">
                        Silakan ikuti instruksi pembayaran di layar berikutnya setelah konfirmasi.
                    </div>
                `;
            }
            detailsContent.innerHTML = html;
        }

        function previewFile(input) {
            const file = input.files[0];
            const uploadBox = document.querySelector('.upload-box');
            const preview = document.getElementById('preview');
            const icon = document.getElementById('upload-icon');
            const text = document.getElementById('upload-text');
            const subtext = document.getElementById('upload-subtext');
            
            if (file) {
                uploadBox.classList.add('has-file');
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        icon.style.display = 'none';
                        text.textContent = 'File terpilih: ' + file.name;
                        subtext.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    // PDF or other
                    preview.style.display = 'none';
                    icon.className = 'fas fa-file-pdf';
                    icon.style.display = 'block';
                    text.textContent = 'File terpilih: ' + file.name;
                    subtext.style.display = 'none';
                }
            }
        }

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const method = document.getElementById('metode_pembayaran_input').value;
            if (!method) {
                e.preventDefault();
                document.getElementById('payment-error').style.display = 'block';
                // Scroll to payment options
                document.querySelector('.payment-grid').scrollIntoView({behavior: 'smooth'});
            }
        });
    </script>
    
</body>
</html>