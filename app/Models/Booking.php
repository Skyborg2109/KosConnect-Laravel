<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    
    protected $table = 'booking';
    
    protected $fillable = [
        'penyewa_id',
        'kamar_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_bulan',
        'total_harga',
        'status',
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'durasi_bulan' => 'integer',
        'total_harga' => 'decimal:2',
    ];
    
    // Relationship: Booking belongs to Penyewa (User)
    public function penyewa()
    {
        return $this->belongsTo(data_user_model::class, 'penyewa_id');
    }
    
    // Relationship: Booking belongs to Kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
    
    // Relationship: Booking has many Pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
    
    // Helper method to get Kos through Kamar
    public function kos()
    {
        return $this->kamar->kos ?? null;
    }
    
    // Helper method to check if booking is active
    public function isActive()
    {
        return $this->status === 'aktif';
    }
    
    // Helper method to check if booking is pending
    public function isPending()
    {
        return $this->status === 'menunggu_konfirmasi';
    }

    /**
     * Automatically complete bookings that have passed their end date.
     * This updates the booking status to 'selesai' and the associated room to 'tersedia'.
     */
    public static function autoCompleteExpired()
    {
        $expiredBookings = self::where('status', 'aktif')
            ->where('tanggal_selesai', '<', now()->toDateString())
            ->with(['kamar.kos', 'penyewa'])
            ->get();

        if ($expiredBookings->count() > 0) {
            \Log::info('autoCompleteExpired found ' . $expiredBookings->count() . ' expired bookings.');
        }

        foreach ($expiredBookings as $booking) {
            \Log::info('Processing expired booking ID: ' . $booking->id);
            
            $booking->update(['status' => 'selesai']);
            if ($booking->kamar) {
                $booking->kamar->update(['status' => 'tersedia']);
            }
            
            // Create notification for penyewa
            Notifikasi::create([
                'user_id' => $booking->penyewa_id,
                'judul' => 'Masa Sewa Berakhir',
                'pesan' => 'Masa sewa Anda untuk kamar ' . ($booking->kamar->nomor_kamar ?? '') . ' di ' . ($booking->kamar->kos->nama_kos ?? 'Kos') . ' telah berakhir.',
                'link' => '/riwayat-booking',
                'tipe' => 'rental_ended',
                'is_read' => false,
            ]);

            // Create notification for pemilik
            if ($booking->kamar && $booking->kamar->kos) {
                \Log::info('Creating notification for pemilik ID: ' . $booking->kamar->kos->pemilik_id);
                Notifikasi::create([
                    'user_id' => $booking->kamar->kos->pemilik_id,
                    'judul' => 'Masa Sewa Berakhir',
                    'pesan' => 'Masa sewa penyewa ' . ($booking->penyewa->nama_user ?? 'Penyewa') . ' untuk kamar ' . ($booking->kamar->nomor_kamar ?? '') . ' telah berakhir.',
                    'link' => '/pemilik/kelola-pesanan',
                    'tipe' => 'rental_ended',
                    'is_read' => false,
                ]);
            } else {
                \Log::warning('Booking ID ' . $booking->id . ' has no kamar or kos.');
            }
        }

        return $expiredBookings->count();
    }
}
