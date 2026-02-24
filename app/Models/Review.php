<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $table = 'review';
    
    protected $fillable = [
        'penyewa_id',
        'kos_id',
        'rating',
        'komentar',
    ];
    
    // Relationship: Review belongs to Penyewa (User)
    public function penyewa()
    {
        return $this->belongsTo(data_user_model::class, 'penyewa_id');
    }
    
    // Relationship: Review belongs to Kos
    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}
