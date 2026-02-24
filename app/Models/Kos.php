<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kos extends Model
{
    use HasFactory;
    
    protected $table = 'kos';
    
    protected $fillable = [
        'nama_kos',
        'pemilik_id',
        'alamat',
        'kota',
        'provinsi',
        'harga_dasar',
        'deskripsi',
        'fasilitas',
        'peraturan',
        'gambar',
        'status',
        'jenis_kos',
    ];
    
    protected $casts = [
        'fasilitas' => 'array',
        'peraturan' => 'array',
        'harga_dasar' => 'decimal:2',
    ];
    
    // Relationship: Kos belongs to Pemilik (User)
    public function pemilik()
    {
        return $this->belongsTo(data_user_model::class, 'pemilik_id');
    }
    
    // Relationship: Kos has many Kamar
    public function kamar()
    {
        return $this->hasMany(Kamar::class);
    }
    
    // Relationship: Kos has many Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    // Relationship: Kos has many Wishlist entries
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    
    // Relationship: Kos has many Keluhan
    public function keluhans()
    {
        return $this->hasMany(Keluhan::class);
    }

    // Relationship: Kos has many Images
    public function images()
    {
        return $this->hasMany(KosImage::class);
    }
    
    // Helper method to get average rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
    
    // Helper method to count total reviews
    public function totalReviews()
    {
        return $this->reviews()->count();
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
