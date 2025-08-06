<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';
    protected $fillable = [
        'admin_id',
        'petugas_id',
        'penghuni_id',
        'aksi',
        'aksi_id',
        'tipe_aksi',
        'deskripsi',
    ];

    public function admin() {
        return $this->belongsTo(User::class);
    }
    public function petugas() {
        return $this->belongsTo(Petugas::class);
    }
    public function penghuni() {
        return $this->belongsTo(Penghuni::class);
    }
}
