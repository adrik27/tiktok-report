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
        Schema::create('riwayat_perbandingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perbandingan_id');

            $table->date('tanggal');
            $table->integer('impression')->nullable();
            $table->integer('click')->nullable();
            $table->integer('page_view')->nullable();
            $table->integer('initiate')->nullable();
            $table->decimal('cost', 12, 2)->nullable();

            // metrik turunan
            $table->decimal('ctr', 8, 2)->nullable();
            $table->decimal('cpc', 12, 2)->nullable();
            $table->decimal('cpv', 12, 2)->nullable();
            $table->decimal('cost_initiate', 12, 2)->nullable();

            $table->timestamps();

            $table->foreign('perbandingan_id')
                ->references('id')
                ->on('perbandingans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_perbandingans');
    }
};
