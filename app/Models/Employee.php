<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * $fillable berisi daftar kolom yang 'diizinkan'
     * untuk diisi secara massal (mass assignment)
     *
     * Isi dengan SEMUA kolom dari migrasi kamu,
     * KECUALI id dan timestamps.
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'status',
    ];
}
