<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Employee extends Model
{
    use HasFactory;

    /**
     * $fillable berisi daftar kolom yang 'diizinkan'
     * untuk diisi secara massal (mass assignment)
     *
     * TAMBAHKAN department_id dan jabatan_id
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'status',
        'department_id', // <-- Tambahkan ini
        'jabatan_id',    // <-- Tambahkan ini
    ];

    /**
     * Relasi ke tabel Department (Satu Pegawai Punya Satu Departemen).
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relasi ke tabel Position (Satu Pegawai Punya Satu Jabatan).
     *
     * KITA HARUS MENAMBAHKAN 'jabatan_id' SEBAGAI ARGUMEN KEDUA
     * untuk memberitahu Laravel bahwa nama kolom foreign key-nya
     * adalah 'jabatan_id', BUKAN 'position_id' (default).
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }
}
