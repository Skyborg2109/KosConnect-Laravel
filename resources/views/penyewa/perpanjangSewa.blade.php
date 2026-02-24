@extends('penyewa.layout')

@section('title', 'Perpanjang Sewa')

@section('active-booking', 'active')

@section('styles')
<style>
    .container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .modal-container {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .modal-header h3 {
        font-size: 22px;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }
    
    .modal-body {
        padding: 30px 24px;
    }
    
    .info-text {
        font-size: 14px;
        color: #495057;
        margin-bottom: 24px;
        padding: 16px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }
    
    .info-text strong {
        color: #212529;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-group select,
    .form-group input[type="text"] {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 16px;
        color: #333;
        outline: none;
        transition: all 0.2s ease;
        background-color: #f8fafc;
    }
    
    .form-group input[readonly] {
        background-color: #f1f3f5;
        color: #6c757d;
        cursor: not-allowed;
    }

    .form-group select {
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5z%22%20fill%3D%22%236c757d%22%2F%3E%3C%2Fsvg%3E');
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        cursor: pointer;
    }
    
    .form-group select:focus,
    .form-group input:focus:not([readonly]) {
        border-color: #667eea;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .total-biaya {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 8px;
    }
    
    .total-biaya span {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
    }
    
    .total-biaya .harga {
        font-size: 26px;
        font-weight: 700;
        color: #ffffff;
    }

    .modal-footer {
        padding: 20px 24px;
        border-top: 1px solid #e9ecef;
        background-color: #f8f9fa;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    
    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-batal {
        background-color: #e9ecef;
        color: #495057;
    }

    .btn-batal:hover {
        background-color: #dee2e6;
    }
    
    .btn-konfirmasi {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
    }

    .btn-konfirmasi:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-konfirmasi:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="modal-container">
        
        <div class="modal-header">
            <h3>Perpanjang Sewa</h3>
        </div>
        
        <form action="/perpanjang-sewa" method="POST" id="extensionForm">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            
            <div class="modal-body">
                
                <p class="info-text">
                    Anda akan memperpanjang sewa untuk <strong>{{ $booking->kamar->kos->nama_kos }}</strong> - Kamar {{ $booking->kamar->nomor_kamar }}.
                    <br>Sewa Anda saat ini berakhir pada: <strong>{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d/m/Y') }}</strong>
                </p>
                
                <div class="form-group">
                    <label for="durasi">Durasi Perpanjangan (bulan)</label>
                    <select id="durasi" name="durasi_bulan" required onchange="calculateNewDate()">
                        <option value="" disabled selected>Pilih durasi</option>
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                    @error('durasi_bulan')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="tanggal-berakhir-baru">Tanggal Berakhir Baru</label>
                    <input type="text" id="tanggal-berakhir-baru" value="-" readonly>
                </div>
                
                <div class="total-biaya">
                    <span>Total Biaya:</span>
                    <span class="harga" id="totalBiaya">Rp 0</span>
                </div>
                
            </div>
            
            <div class="modal-footer">
                <a href="/booking-aktif" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-konfirmasi" id="submitBtn" disabled>Lanjut Ke Pembayaran</button>
            </div>
        </form>
        
    </div>
</div>

<script>
    const currentEndDate = new Date('{{ $booking->tanggal_selesai }}');
    const monthlyPrice = {{ $booking->kamar->harga }};
    
    function calculateNewDate() {
        const durasi = parseInt(document.getElementById('durasi').value);
        
        if (!durasi) {
            document.getElementById('tanggal-berakhir-baru').value = '-';
            document.getElementById('totalBiaya').textContent = 'Rp 0';
            document.getElementById('submitBtn').disabled = true;
            return;
        }
        
        // Calculate new end date (start from day after current end date)
        const newStartDate = new Date(currentEndDate);
        newStartDate.setDate(newStartDate.getDate() + 1);
        
        const newEndDate = new Date(newStartDate);
        newEndDate.setMonth(newEndDate.getMonth() + durasi);
        
        // Format date as dd/mm/yyyy
        const day = String(newEndDate.getDate()).padStart(2, '0');
        const month = String(newEndDate.getMonth() + 1).padStart(2, '0');
        const year = newEndDate.getFullYear();
        
        document.getElementById('tanggal-berakhir-baru').value = `${day}/${month}/${year}`;
        
        // Calculate total cost
        const totalCost = monthlyPrice * durasi;
        document.getElementById('totalBiaya').textContent = 'Rp ' + totalCost.toLocaleString('id-ID');
        
        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
    }
</script>

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#667eea'
        });
    </script>
@endif

@if(session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#667eea'
        });
    </script>
@endif

@endsection