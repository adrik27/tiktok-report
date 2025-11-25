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
            $table->enum('platform', ['tiktok', 'gmvmax']);
            $table->string('jenis_campaign')->nullable();

            $table->decimal('cost')->nullable();

            // tiktok metrics
            $table->integer('impression')->nullable();
            $table->integer('click')->nullable();
            $table->decimal('cpc')->nullable();
            $table->integer('page_view')->nullable();
            $table->decimal('cpv')->nullable();
            $table->integer('initiate')->nullable();

            // tiktok metrik turunan
            $table->decimal('ctr', 12, 2)->nullable();
            $table->decimal('cost_initiate', 12, 2)->nullable();
            $table->decimal('convertion_rate', 12, 2)->nullable();

            // gmvmax metrics
            $table->integer('order')->nullable();
            $table->integer('cost_per_order')->nullable();
            $table->integer('gross_revenue')->nullable();
            $table->integer('roi')->nullable();

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
