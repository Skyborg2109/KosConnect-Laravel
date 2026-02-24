
<div class="contact-modal-container">
    <form method="POST" action="/kirimPesan">
        @csrf
        <input type="hidden" name="kos_id" value="{{ $kos->id }}">
        <input type="hidden" name="pemilik_id" value="{{ $kos->pemilik_id }}">
        
        <div class="contact-modal-header">
            <h3>Hubungi Pemilik - {{ $kos->nama_kos }}</h3>
            <button type="button" class="close-btn" onclick="closeContactModal()">&times;</button>
        </div>
        
        <div class="contact-modal-body">
            <div class="kos-info" style="background: #f8f9fa; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <p style="font-size: 14px; color: #6c757d; margin-bottom: 4px;">Kos:</p>
                <p style="font-weight: 600; color: #212529;">{{ $kos->nama_kos }}</p>
                <p style="font-size: 14px; color: #6c757d;">{{ $kos->alamat }}</p>
                @if($kos->pemilik)
                <p style="font-size: 14px; color: #6c757d; margin-top: 8px;">Pemilik: <strong>{{ $kos->pemilik->nama_user }}</strong></p>
                @endif
            </div>
            
            <div class="form-group">
                <label for="message">Pesan</label>
                <textarea id="message" name="message" placeholder="Tulis pesan Anda..." required style="width: 100%; padding: 12px; border: 1px solid #ced4da; border-radius: 4px; min-height: 120px; font-family: inherit; font-size: 14px;"></textarea>
            </div>
        </div>
        
        <div class="contact-modal-footer">
            <button type="button" class="btn btn-batal" onclick="closeContactModal()">Batal</button>
            <button type="submit" class="btn btn-kirim">Kirim</button>
        </div>
    </form>
</div>

<style>
    .contact-modal-container {
        background-color: #ffffff;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .contact-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .contact-modal-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }
    
    .contact-modal-header .close-btn {
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
    
    .contact-modal-header .close-btn:hover {
        color: #343a40;
    }
    
    .contact-modal-body {
        padding: 24px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-group textarea:focus {
        outline: none;
        border-color: #0d6efd;
    }
    
    .contact-modal-footer {
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
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-batal {
        background-color: #e9ecef;
        color: #495057;
    }
    
    .btn-batal:hover {
        background-color: #dee2e6;
    }
    
    .btn-kirim {
        background-color: #0d6efd;
        color: #ffffff;
    }
    
    .btn-kirim:hover {
        background-color: #0b5ed7;
    }
</style>
