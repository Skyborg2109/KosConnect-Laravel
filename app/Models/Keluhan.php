<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluhan extends Model
{
    use HasFactory;
    
    protected $table = 'keluhan';
    
    protected $fillable = [
        'penyewa_id',
        'kos_id',
        'judul',
        'deskripsi',
        'kategori',
        'prioritas',
        'bukti',
        'status',
        'tanggal_selesai',
    ];
    
    protected $casts = [
        'tanggal_selesai' => 'datetime',
    ];
    
    // Relationship: Keluhan belongs to Penyewa (User)
    public function penyewa()
    {
        return $this->belongsTo(data_user_model::class, 'penyewa_id');
    }
    
    // Relationship: Keluhan belongs to Kos
    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
    
    // Helper method to check if pending
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    // Helper method to check if in progress
    public function isDiproses()
    {
        return $this->status === 'diproses';
    }
    
    // Helper method to check if completed
    public function isSelesai()
    {
        return $this->status === 'selesai';
    }
}
