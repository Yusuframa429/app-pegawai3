<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();

            // 1. Jembatan ke tabel employees
            $table->unsignedBigInteger('employee_id');

            // 2. Jembatan ke tabel positions
            // (Kita pakai 'jabatan_id' agar konsisten dengan migrasi kamu)
            $table->unsignedBigInteger('jabatan_id');

            $table->date('tanggal_gaji'); // Tanggal gajian
            $table->decimal('gaji_pokok', 10, 2); // Gaji pokok saat itu (kita rekam)
            $table->decimal('tunjangan', 10, 2)->default(0);
            $table->decimal('potongan', 10, 2)->default(0);
            $table->decimal('gaji_bersih', 10, 2); // Total (gaji pokok + tunjangan - potongan)

            $table->timestamps();

            // 3. Daftarkan "Jembatan" / Foreign Keys
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
