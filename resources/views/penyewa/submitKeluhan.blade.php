@extends('penyewa.layout')

@section('title', 'Submit Keluhan')

@section('active-submitKeluhan', 'active')

@section('styles')
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
        }

        .container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 0 20px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }



        /* == CSS HALAMAN KELUHAN == */

        .page-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        /* Tata Letak 2 Kolom */
        .complaint-layout {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 kolom sama besar */
            gap: 20px;
            align-items: start; 
        }
        
        /* Kartu putih */
        .complaint-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 24px;
        }
        
        .complaint-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        /* Style Form Umum */
        .complaint-form .form-group {
            margin-bottom: 20px;
        }
        
        .complaint-form label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .complaint-form select,
        .complaint-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
        }
        
        .complaint-form select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5z%22%20fill%3D%22%236c757d%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }
        
        .complaint-form textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        /* Upload Box */
        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
        }
        
        .upload-box .icon {
            font-size: 28px;
            color: #adb5bd;
            margin-bottom: 12px;
        }
        
        .upload-box .text-main {
            font-size: 14px;
            color: #0d6efd; /* Biru */
            font-weight: 600;
        }
        
        .upload-box .text-secondary {
            font-size: 12px;
            color: #6c757d;
        }
        
        /* Tombol Submit */
        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #ffffff;
            background-color: #dc3545; /* Merah */
        }
        
        /* Riwayat di Kanan */
        .history-empty-state {
            display: grid;
            place-items: center;
            min-height: 200px;
            color: #6c757d;
        }
        
    </style>
@endsection

@section('content')
        
        <h1 class="page-title">Submit Keluhan</h1>

        <div class="complaint-layout">
            
            <section class="complaint-card">
                <h3>Form Keluhan</h3>
                
                @if(session('success'))
                    <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form class="complaint-form" action="{{ url('/store-keluhan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="kos_id">Pilih Kos</label>
                        <select id="kos_id" name="kos_id" required>
                            <option value="">Pilih Kos</option>
                            @foreach($kosList as $kos)
                                <option value="{{ $kos->id }}" {{ old('kos_id') == $kos->id ? 'selected' : '' }}>{{ $kos->nama_kos }}</option>
                            @endforeach
                        </select>
                        @error('kos_id')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="judul">Judul Keluhan</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: AC Bocor di Kamar 101" style="width: 100%; padding: 12px; border: 1px solid #ced4da; border-radius: 4px;" required>
                        @error('judul')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori Keluhan</label>
                        <select id="kategori" name="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="fasilitas" {{ old('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas Rusak</option>
                            <option value="kebersihan" {{ old('kategori') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="keamanan" {{ old('kategori') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="prioritas">Tingkat Prioritas</label>
                        <select id="prioritas" name="prioritas" required>
                            <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                        @error('prioritas')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Keluhan</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan keluhan Anda secara detail..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="bukti">Upload Bukti (Opsional)</label>
                        <div class="upload-box" onclick="document.getElementById('bukti').click()" style="cursor: pointer;">
                            <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <span class="text-main" id="file-label">Upload file</span> atau drag and drop
                            <br>
                            <span class="text-secondary">PNG, JPG, PDF hingga 5MB</span>
                        </div>
                        <input type="file" id="bukti" name="bukti" style="display: none;" onchange="updateFileName(this)">
                        @error('bukti')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-submit">Kirim Keluhan</button>
                </form>

                <script>
                    function updateFileName(input) {
                        if (input.files && input.files[0]) {
                            document.getElementById('file-label').textContent = input.files[0].name;
                        }
                    }
                </script>
            </section>
            
            <section class="complaint-card">
                <h3>Riwayat Keluhan</h3>
                <div class="history-empty-state">
                    <!-- Ideally we should fetch and display history here, but leaving empty as per original design for now -->
                    <p>Cek riwayat keluhan di menu Notifikasi atau tanyakan pemilik.</p>
                </div>
            </section>
            
        </div>

@endsection