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
        Schema::create('pengembang', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable(false)->comment('ID Pengguna');
            $table->string('sertifikat_sp2', 100);
            $table->text('alamat');
            $table->boolean('is_verified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembang');
    }
};
