<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kamar extends Model
{
    use HasFactory;
    
    protected $table = 'kamar';
    
    protected $fillable = [
        'kos_id',
        'nomor_kamar',
        'tipe_kamar',
        'harga',
        'luas',
        'fasilitas',
        'status',
        'gambar',
    ];
    
    protected $casts = [
        'fasilitas' => 'array',
        'harga' => 'decimal:2',
    ];
    
    // Relationship: Kamar belongs to Kos
    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
    
    // Relationship: Kamar has many Bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relationship: Kamar has many Images
    public function images()
    {
        return $this->hasMany(KamarImage::class);
    }
    
    // Helper method to check if kamar is available
    public function isAvailable()
    {
        return $this->status === 'tersedia';
    }
    
    // Helper method to get active booking
    public function activeBooking()
    {
        return $this->bookings()
            ->where('status', 'aktif')
            ->first();
    }

    // Accessor to safely get image URL
    public function getGambarUrlAttribute()
    {
        if ($this->gambar && !empty(trim($this->gambar))) {
            if (strpos($this->gambar, 'http') === 0) {
                return $this->gambar;
            }
            return asset('storage/' . $this->gambar);
        }
        return null;
    }
}
