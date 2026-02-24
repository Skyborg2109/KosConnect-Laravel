<div class="konfirmasi-modal-container">
    <form action="{{ url('/store-booking') }}" method="POST" id="konfirmasiSewaForm">
        @csrf
        
        <input type="hidden" name="kos_id" value="{{ $kos->id ?? '' }}">
        
        <div class="modal-header">
            <h3>Konfirmasi Sewa</h3>
            <button type="button" class="close-btn" onclick="closeKonfirmasiModal()">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="kos-summary" style="display: flex; gap: 15px; align-items: center; background: #f8f9fa; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                @if($kos->gambar)
                    <img src="{{ $kos->gambar_url }}" alt="{{ $kos->nama_kos }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                @else
                    <div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-home" style="color: #adb5bd;"></i>
                    </div>
                @endif
                <div>
                    <strong style="font-size: 16px; color: #1e293b;">{{ $kos->nama_kos }}</strong><br>
                    <small style="color: #64748b;"><i class="fas fa-map-marker-alt" style="margin-right: 4px;"></i>{{ $kos->alamat }}, {{ $kos->kota }}</small>
                </div>
            </div>
            
            <div class="form-group">
                <label for="kamar_id">Pilih Kamar</label>
                <select id="kamar_id" name="kamar_id" required onchange="updateRoomSelection()">
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
                <input type="date" id="tanggal-mulai" name="tanggal_mulai" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
            </div>
            
            <div class="form-group">
                <label for="durasi">Durasi (bulan)</label>
                <select id="durasi" name="durasi_bulan" class="durasi-select" data-harga="{{ optional($kamar)->harga ?? $kos->harga_dasar ?? 0 }}" required onchange="updateTotalKonfirmasi()">
                    <option value="" disabled selected>Pilih durasi</option>
                    <option value="1">1 Bulan</option>
                    <option value="3">3 Bulan</option>
                    <option value="6">6 Bulan</option>
                    <option value="12">12 Bulan</option>
                </select>
            </div>
            
            <div class="total-biaya">
                <span>Total Biaya:</span>
                <span class="harga" id="total-harga-konfirmasi">Rp 0</span>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-batal" onclick="closeKonfirmasiModal()">Batal</button>
            <button type="submit" class="btn btn-konfirmasi">Konfirmasi</button>
        </div>
    </form>
</div>

<style>
    .konfirmasi-modal-container {
        background-color: #ffffff;
        border-radius: 8px;
        width: 100%;
        max-width: 600px;
        margin: 0 auto; /* Supaya rata tengah horizontal */
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .konfirmasi-modal-container .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .konfirmasi-modal-container .modal-header h3 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
    }
    
    .konfirmasi-modal-container .close-btn {
        font-size: 28px;
        color: #6c757d;
        background: none;
        border: none;
        cursor: pointer;
        line-height: 1;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }
    
    .konfirmasi-modal-container .close-btn:hover {
        color: #343a40;
    }
    
    .konfirmasi-modal-container .modal-body {
        padding: 24px;
    }
    
    .kos-summary {
        margin-bottom: 20px;
        background: #f8f9fa;
        padding: 12px;
        border-radius: 4px;
    }
    
    .kos-summary strong {
        font-size: 16px;
        color: #212529;
    }
    
    .kos-summary small {
        font-size: 14px;
        color: #6c757d;
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
    
    .form-group select {
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5z%22%20fill%3D%22%236c757d%22%2F%3E%3C%2Fsvg%3E');
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
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
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
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
    
    .konfirmasi-modal-container .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #e9ecef;
        background-color: #f8f9fa;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .konfirmasi-modal-container .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .konfirmasi-modal-container .btn-batal {
        background-color: #e9ecef;
        color: #495057;
    }
    
    .konfirmasi-modal-container .btn-batal:hover {
        background-color: #dee2e6;
    }
    
    .konfirmasi-modal-container .btn-konfirmasi {
        background-color: #0d6efd;
        color: #ffffff;
    }
    
    .konfirmasi-modal-container .btn-konfirmasi:hover {
        background-color: #0b5ed7;
    }
</style>

<script>
        function updateRoomSelection() {
            const kamarSelect = document.getElementById('kamar_id');
            const durasiSelect = document.getElementById('durasi');
            if (!kamarSelect || !durasiSelect) return;

            const selectedOption = kamarSelect.options[kamarSelect.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            
            durasiSelect.setAttribute('data-harga', harga);
            
            // Trigger price update if duration is already selected
            if (typeof window.updateTotalKonfirmasi === 'function') {
                window.updateTotalKonfirmasi();
            }
        }
    </script>
</div>


