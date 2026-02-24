<!DOCTYPE html>
<html>
<head>
    <title>Test Manajemen Kos</title>
</head>
<body>
    <h1>Data Kos</h1>
    <p>Total: {{ $kos->count() }}</p>
    
    @if($kos->count() > 0)
        @foreach($kos as $item)
            <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                <h3>{{ $item->nama_kos }}</h3>
                <p>Lokasi: {{ $item->alamat }}, {{ $item->kota }}</p>
                <p>Harga: Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}</p>
                <p>Status: {{ $item->status }}</p>
                <p>Jumlah Kamar: {{ $item->kamar->count() }}</p>
                
                @php
                    $hasImage = $item->gambar && !empty(trim($item->gambar));
                @endphp
                
                @if($hasImage)
                    <p>Ada gambar: {{ $item->gambar }}</p>
                    <img src="{{ asset('storage/' . $item->gambar) }}" style="max-width: 200px;">
                @else
                    <p>Tidak ada gambar</p>
                @endif
            </div>
        @endforeach
    @else
        <p>Belum ada data kos</p>
    @endif
</body>
</html>
