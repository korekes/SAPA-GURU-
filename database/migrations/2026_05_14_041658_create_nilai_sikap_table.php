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
        Schema::create('nilai_sikap', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();

            $table->tinyInteger('disiplin')->nullable();
            $table->tinyInteger('kejujuran')->nullable();
            $table->tinyInteger('tanggung_jawab')->nullable();
            $table->tinyInteger('kemandirian')->nullable();
            $table->tinyInteger('kepedulian')->nullable();

            $table->integer('nilai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_sikap');
    }
};
