<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'jabatan_id',
        'tanggal_gaji',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'gaji_bersih',
    ];

    /**
     * Relasi ke Employee (Satu Gaji Milik Satu Karyawan)
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Relasi ke Position (Satu Gaji terikat Satu Jabatan)
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }
}
