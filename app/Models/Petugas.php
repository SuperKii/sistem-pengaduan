<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $fillable = [
        'nama',
        'email',
        'password',
        'kategori_id'
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }
}
