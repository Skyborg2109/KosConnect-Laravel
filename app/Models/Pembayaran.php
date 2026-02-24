<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;
    
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'booking_id',
        'jumlah',
        'metode_pembayaran',
        'bukti_transfer',
        'status',
        'tanggal_bayar',
        'verified_at',
        'verified_by',
    ];
    
    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'date',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the payment proof image URL.
     *
     * @return string|null
     */
    public function getBuktiTransferUrlAttribute()
    {
        if (!$this->bukti_transfer) {
            return null;
        }

        // If it starts with http, it's already a full URL (like from Cloudinary)
        if (str_starts_with($this->bukti_transfer, 'http')) {
            return $this->bukti_transfer;
        }

        // Otherwise, it's a local storage path
        return asset('storage/' . $this->bukti_transfer);
    }
    
    // Relationship: Pembayaran belongs to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    // Relationship: Pembayaran verified by User (Admin/Pemilik)
    public function verifier()
    {
        return $this->belongsTo(data_user_model::class, 'verified_by');
    }
    
    // Helper method to check if verified
    public function isVerified()
    {
        return $this->status === 'verified';
    }
    
    // Helper method to check if pending
    public function isPending()
    {
        return $this->status === 'pending';
    }
}
