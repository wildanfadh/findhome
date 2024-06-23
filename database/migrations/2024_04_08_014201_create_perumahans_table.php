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
        Schema::create('perumahan', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->integer('pengembang_id')->unsigned()->nullable(false)->comment('ID Pengembang');
            $table->string('nama', 100)->comment('Nama Perumahan');
            $table->float('harga')->comment('Harga Rumah Subsidi tersedia');
            $table->text('alamat');
            $table->string('lat_lang', 200)->nullable();
            $table->longText('keterangan')->nullable();
            $table->boolean('is_verified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perumahan');
    }
};
