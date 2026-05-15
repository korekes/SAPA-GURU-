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
        Schema::create('nilai_aktif', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();

            $table->tinyInteger('diskusi')->nullable();
            $table->tinyInteger('inisiatif')->nullable();
            $table->tinyInteger('kerjasama')->nullable();
            $table->tinyInteger('komunikasi')->nullable();
            $table->tinyInteger('tugas')->nullable();

            $table->integer('nilai')->nullable(); // hasil akhir

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_aktif');
    }
};
