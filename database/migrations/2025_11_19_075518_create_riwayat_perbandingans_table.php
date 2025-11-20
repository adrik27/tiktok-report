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

            $table->decimal('cost')->nullable();
            $table->integer('impression')->nullable();
            $table->integer('click')->nullable();
            $table->decimal('cpc')->nullable();
            $table->integer('page_view')->nullable();
            $table->decimal('cpv')->nullable();
            $table->integer('initiate')->nullable();

            // metrik turunan
            $table->decimal('ctr', 12, 2)->nullable();
            $table->decimal('cost_initiate', 12, 2)->nullable();
            $table->decimal('convertion_rate', 12, 2)->nullable();

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
