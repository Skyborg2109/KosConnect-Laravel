<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginModel extends Model
{
    use HasFactory;

    protected $table = 'data_user';
    
    // Disable timestamps if table doesn't have created_at and updated_at columns
    public $timestamps = false;

    protected $fillable = [
        'nama_user',
        'email',
        'password',
        'role',
        'foto_profil',
    ];

}
