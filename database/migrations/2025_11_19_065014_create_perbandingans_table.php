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
        Schema::create('perbandingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->unsignedBigInteger('user_id');

            $table->text('files')->nullable();
            $table->text('summary')->nullable();
            $table->text('planning')->nullable();

            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbandingans');
    }
};
