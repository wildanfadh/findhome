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
        Schema::create('rekomendasi_preferensi', function (Blueprint $table) {
            $table->id();
            $table->integer('preferensi_id')->unsigned()->comment('ID Preferensi');
            $table->integer('perumahan_id')->unsigned()->comment('ID Perumahan');
            $table->float('nilai_hasil_uji')->nullable(false)->default(0)->comment('Nilai Hasil Uji Rekomendasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_preferensi');
    }
};
