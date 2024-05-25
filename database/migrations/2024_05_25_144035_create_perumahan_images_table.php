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
        Schema::create('perumahan_image', function (Blueprint $table) {
            $table->id();
            $table->integer('perumahan_id')->unsigned();
            $table->string('path');
            $table->string('name');
            $table->string('original_name');
            $table->string('mime', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perumahan_image');
    }
};
