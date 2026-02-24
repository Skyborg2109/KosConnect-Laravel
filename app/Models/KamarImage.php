<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarImage extends Model
{
    use HasFactory;

    protected $table = 'kamar_images';

    protected $fillable = [
        'kamar_id',
        'image_url',
        'order',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
