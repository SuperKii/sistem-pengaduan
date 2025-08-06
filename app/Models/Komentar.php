<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    protected $fillable = [
        'deskripsi',
        'admin_id',
        'keluhan_id'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
