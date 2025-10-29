<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * $fillable berisi daftar kolom yang 'diizinkan'
     * untuk diisi secara massal (mass assignment)
     */
    protected $fillable = [
        'nama_departemen',
    ];
}
