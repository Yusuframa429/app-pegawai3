<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import

class Attendence extends Model
{
    use HasFactory;

    /**
     * Nama tabelnya 'attendence' (bukan 'attendences')
     * Laravel pintar, tapi kadang ejaan kustom perlu diberitahu
     */
    protected $table = 'attendence';

    /**
     * $fillable berisi daftar kolom yang 'diizinkan'
     * untuk diisi secara massal
     */
    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status_absensi',
    ];

    /**
     * Relasi ke tabel Employee (Satu Absensi Milik Satu Karyawan).
     *
     * Kita beritahu Laravel:
     * 1. Relasinya ke model Employee::class
     * 2. Nama kolom "jembatan"-nya adalah 'karyawan_id'
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
}
