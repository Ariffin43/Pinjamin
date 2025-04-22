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
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id('id');
            $table->string('merk');
            $table->string('no_plat');
            $table->string('jenis_kendaraan');
            $table->text('detail_kendaraan')->nullable();
            $table->enum('status_kendaraan', ['Available', 'Digunakan', 'Perbaikan'])->default('Available');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
