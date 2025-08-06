<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $table = 'keluhan';
    protected $fillable = [
        'deskripsi',
        'penghuni_id',
        'kategori_id',
        'petugas_id',
        'foto_keluhan',
        'foto_selfie',
        'status',
        'proses_at',
        'selesai_at'
    ];

    public function penghuni() {
        return $this->belongsTo(Penghuni::class);
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function petugas() {
        return $this->belongsTo(Petugas::class);
    }

}
