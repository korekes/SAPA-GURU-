<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jurnals', function (Blueprint $table) {
            $table->text('kegiatan')->nullable();
            $table->text('tujuan_pembelajaran')->nullable();

            // optional: hapus keterangan kalau tidak dipakai
            $table->dropColumn('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurnals', function (Blueprint $table) {
            //
        });
    }
};
