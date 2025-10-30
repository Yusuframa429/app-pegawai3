<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    /**
     * $fillable berisi daftar kolom yang 'diizinkan'
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'status',
        'department_id',
        'jabatan_id',
    ];

    /**
     * Relasi ke tabel Department
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relasi ke tabel Position
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }

    /**
     * Relasi sebaliknya ke Gaji
     */
    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class, 'employee_id');
    }

    /**
     * Relasi sebaliknya ke tabel Attendence
     */
    public function attendences(): HasMany
    {
        return $this->hasMany(Attendence::class, 'karyawan_id');
    }
}
