<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penghuni extends Authenticatable
{
    use HasFactory;

    protected $table = 'penghuni';
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat_unit',
        'foto'
    ];
}
