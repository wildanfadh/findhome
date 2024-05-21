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
        Schema::create('pengembang_sertifikat', function (Blueprint $table) {
            $table->id();
            $table->integer('pengembang_id')->unsigned();
            $table->string('path');
            $table->string('name');
            $table->string('original_name');
            $table->string('mime', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembang_sertifikat');
    }
};
