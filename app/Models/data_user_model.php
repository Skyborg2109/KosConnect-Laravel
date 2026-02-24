<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class data_user_model extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'data_user';
    
    // Disable timestamps if table doesn't have created_at and updated_at columns
    public $timestamps = false;
    
    protected $fillable = [
        'nama_user',
        'email',
        'nomor_telepon',
        'password',
        'role',
        'status',
        'google_id',
        'facebook_id',
        'twitter_id',
        'avatar',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'foto_profil',
    ];
}
