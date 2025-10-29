<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_departemen',
    ];

    /**
     * Relasi sebaliknya ke tabel Employee
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
