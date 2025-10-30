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
        Schema::table('employees', function (Blueprint $table) {
            // 1. Buat kolom user_id
            // Kita buat 'nullable' agar data lama tidak error
            // Kita buat 'after('id')' agar rapi di database
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            // 2. Buat "jembatan" (Foreign Key)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null'); // Jika user dihapus, user_id di employee jadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // 1. Hapus jembatan
            $table->dropForeign(['user_id']);

            // 2. Hapus kolom
            $table->dropColumn('user_id');
        });
    }
};
