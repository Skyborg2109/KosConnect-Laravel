<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;
    
    protected $table = 'notifikasi';
    
    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'link',
        'tipe',
        'is_read',
    ];
    
    protected $casts = [
        'is_read' => 'boolean',
    ];
    
    // Relationship: Notifikasi belongs to User
    public function user()
    {
        return $this->belongsTo(data_user_model::class, 'user_id');
    }
    
    // Helper method to mark as read
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
    
    // Helper method to check if unread
    public function isUnread()
    {
        return !$this->is_read;
    }
}
