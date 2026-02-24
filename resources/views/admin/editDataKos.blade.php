<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kos - KosConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .header p {
            color: #64748b;
            font-size: 14px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background-color: #6b7280;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #4b5563;
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

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background-color: white;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #7c3aed;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #6d28d9;
        }

        a.btn {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <div class="header">
            <h1>Edit Data Kos</h1>
            <p>Edit data {{ $kos->name ?? 'Royal Kost' }}</p>
        </div>

        <form action="/update-kos" method="POST">
            @csrf
            <input type="hidden" name="kos_name" value="{{ $kos->name ?? '' }}">

            <div class="form-group">
                <label class="form-label" for="kosName">Nama Kos</label>
                <input type="text" id="kosName" name="kosName" class="form-input" value="{{ $kos->name ?? 'Royal Kost' }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="kosAddress">Alamat Kos</label>
                <input type="text" id="kosAddress" name="kosAddress" class="form-input" value="{{ $kos->address ?? 'Jl. Contoh No. 123, Kota' }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="kosDescription">Deskripsi Kos</label>
                <textarea id="kosDescription" name="kosDescription" class="form-input" rows="4" required>{{ $kos->description ?? 'Kos nyaman dengan fasilitas lengkap untuk mahasiswa.' }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="kosFacilities">Fasilitas Kos</label>
                <input type="text" id="kosFacilities" name="kosFacilities" class="form-input" value="{{ $kos->facilities ?? 'WiFi, AC, Kamar Mandi Dalam' }}" placeholder="Contoh: WiFi, AC, Kamar Mandi Dalam">
            </div>

            <div class="form-group">
                <label class="form-label" for="kosBasePrice">Harga Dasar per Bulan (Rp)</label>
                <input type="number" id="kosBasePrice" name="kosBasePrice" class="form-input" value="{{ $kos->base_price ?? '750000' }}" required min="0">
            </div>

            <a href="/editDataKos" class="btn-primary">Update Data Kos</a>
        </form>
    </div>
</body>
</html>