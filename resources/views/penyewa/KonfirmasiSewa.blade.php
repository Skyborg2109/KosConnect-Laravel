<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Sewa - {{ $kos->nama_kos ?? 'Kos' }}</title>
    
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
            background-color: #f8f9fa; /* Latar belakang body abu-abu */
            color: #333;
            line-height: 1.6;
            
            /* Trik untuk menengahkan modal di layar */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* ===================================== */
        /* == CSS MODAL KONFIRMASI SEWA == */
        /* ===================================== */

        .modal-container {
            background-color: #ffffff;
            border-radius: 8px;
            width: 100%;
            max-width: 480px; /* Lebar modal */
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            z-index: 1001;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .modal-header h3 {
            font-size: 20px;
            font-weight: 600;
        }
        
        .modal-header .close-btn {
            font-size: 24px;
            color: #6c757d;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        
        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        /* Wrapper untuk input dengan ikon */
        .input-with-icon {
            position: relative;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-family: inherit;
            font-size: 16px;
            color: #333;
            outline: none;
            transition: border-color 0.2s ease;
        }
        
        /* Penyesuaian padding jika ada ikon */
        .input-with-icon input {
            padding-right: 40px; /* Ruang untuk ikon */
        }
        
        .input-with-icon .icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
        }

        .form-group select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5z%22%20fill%3D%22%236c757d%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            font-size: 16px;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            border-color: #0d6efd;
        }
        
        .total-biaya {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
        }
        
        .total-biaya span {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        
        .total-biaya .harga {
            font-size: 24px;
            font-weight: 700;
            color: #0d6efd;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #e9ecef;
            background-color: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-batal {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .btn-konfirmasi {
            background-color: #0d6efd;
            color: #ffffff;
        }
        
        .kos-summary {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
    </style>
</head>
<body>

    <div class="modal-container">
        
        <div class="modal-header">
            <h3>Konfirmasi Sewa</h3>
            <a href="{{ url('/dashboard-penyewa') }}" class="close-btn">&times;</a>
        </div>
        
        <form action="{{ url('/store-booking') }}" method="POST" class="form-confirm-booking">

            @csrf
            
            @if(isset($booking))
                 <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            @endif
            <input type="hidden" name="kos_id" value="{{ $kos->id ?? '' }}">

            <div class="modal-body">
                @if(session('error'))
                    <div class="alert-error">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(isset($kos))
                <div class="kos-summary" style="display: flex; gap: 15px; align-items: center; background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #e9ecef;">
                    @if($kos->gambar)
                        <img src="{{ $kos->gambar_url }}" alt="{{ $kos->nama_kos }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                    @else
                        <div style="width: 80px; height: 80px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-home" style="font-size: 32px; color: #adb5bd;"></i>
                        </div>
                    @endif
                    <div>
                        <strong style="font-size: 18px; color: #1e293b; display: block; margin-bottom: 4px;">{{ $kos->nama_kos }}</strong>
                        <span style="color: #64748b; font-size: 14px;"><i class="fas fa-map-marker-alt" style="margin-right: 6px;"></i>{{ $kos->alamat }}, {{ $kos->kota }}</span>
                    </div>
                </div>
                @endif
                
                <div class="form-group">
                    <label for="kamar_id">Pilih Kamar</label>
                    <select id="kamar_id" name="kamar_id" required onchange="updateRoomPrice()">
                        @if(isset($availableKamars) && $availableKamars->count() > 0)
                            @foreach($availableKamars as $ak)
                                <option value="{{ $ak->id }}" data-harga="{{ $ak->harga }}" {{ isset($kamar) && $kamar->id == $ak->id ? 'selected' : '' }}>
                                    Kamar {{ $ak->nomor_kamar }} - {{ $ak->tipe_kamar }} (Rp {{ number_format($ak->harga, 0, ',', '.') }}/bln)
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled selected>Tidak ada kamar tersedia</option>
                        @endif
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tanggal-mulai">Tanggal Mulai</label>
                    <div class="input-with-icon">
                        <input type="date" id="tanggal-mulai" name="tanggal_mulai" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                        <!-- <i class="fas fa-calendar-alt icon"></i> date input has its own icon -->
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="durasi">Durasi (bulan)</label>
                    <select id="durasi" name="durasi_bulan" required onchange="updateTotal()">
                        <option value="" disabled selected>Pilih durasi</option>
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                </div>
                
                <div class="total-biaya">
                    <span>Total Biaya:</span>
                    <span class="harga" id="total-harga">Rp 0</span>
                </div>
                
            </div>
            
            <div class="modal-footer">
                <a href="{{ url('/dashboard-penyewa') }}" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-konfirmasi">Konfirmasi</button>
            </div>
        </form>
        
    </div>
    
    <script>
        // Set initial room price
        let hargaPerBulan = 0;
        
        function updateRoomPrice() {
            const kamarSelect = document.getElementById('kamar_id');
            if (!kamarSelect) return;
            
            const selectedOption = kamarSelect.options[kamarSelect.selectedIndex];
            hargaPerBulan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            console.log('Update Harga per bulan:', hargaPerBulan);
            
            updateTotal();
        }

        // Initialize on load
        window.onload = function() {
            updateRoomPrice();
        };
        
        function updateTotal() {
            const durasiSelect = document.getElementById('durasi');
            const durasi = parseInt(durasiSelect.value) || 0;
            
            console.log('Durasi dipilih:', durasi);
            console.log('Harga per bulan:', hargaPerBulan);
            
            if (hargaPerBulan > 0 && durasi > 0) {
                const total = hargaPerBulan * durasi;
                console.log('Total:', total);
                
                // Format Rupiah
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(total);
                
                document.getElementById('total-harga').textContent = formatted;
            } else {
                console.log('Harga atau durasi tidak valid');
                document.getElementById('total-harga').textContent = 'Rp 0';
            }
        }
    </script>
    
</body>
</html>