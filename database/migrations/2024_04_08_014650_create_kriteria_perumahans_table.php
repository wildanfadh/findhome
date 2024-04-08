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
        Schema::create('kriteria_perumahan', function (Blueprint $table) {
            $table->id();
            $table->integer('perumahan_id')->unsigned()->comment('ID Perumahan');
            $table->integer('kriteria_id')->unsigned()->comment('ID Kriteria');
            $table->integer('sub_kriteria_id')->nullable()->unsigned()->comment('ID Sub Kriteria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_perumahan');
    }
};
