<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;
    
    protected $table = 'wishlist';
    
    protected $fillable = [
        'penyewa_id',
        'kos_id',
    ];
    
    // Relationship: Wishlist belongs to Penyewa (User)
    public function penyewa()
    {
        return $this->belongsTo(data_user_model::class, 'penyewa_id');
    }
    
    // Relationship: Wishlist belongs to Kos
    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}
