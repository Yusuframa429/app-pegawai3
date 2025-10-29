<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
    ];

    /**
     * Relasi sebaliknya ke tabel Employee
     * Kita juga harus spesifikkan 'jabatan_id' di sini
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'jabatan_id');
    }
}
