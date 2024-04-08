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
        Schema::create('preferensi', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->comment('ID Pengguna');
            $table->integer('kriteria_id')->unsigned()->nullable()->default(NULL)->comment('ID Kriteria yang dipilih oleh pengguna');
            $table->integer('sub_kriteria_id')->unsigned()->nullable()->default(NULL)->comment('ID Sub Kriteria yang dipilih oleh pengguna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi');
    }
};
