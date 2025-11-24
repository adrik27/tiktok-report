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
        Schema::create('campaign_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->foreignId('user_id');
            $table->enum('platform', ['tiktok', 'gmvmax']);
            $table->string('jenis_campaign');

            $table->integer('cost')->nullable();
            $table->integer('cpm')->nullable();
            $table->integer('impression')->nullable();
            $table->decimal('klik')->nullable();
            $table->integer('cpc')->nullable();
            $table->integer('page_view')->nullable();
            $table->integer('cpv')->nullable();
            $table->integer('initiate')->nullable();
            $table->integer('cost_per_initiate')->nullable();
            $table->decimal('result')->nullable();
            $table->integer('cpr')->nullable();
            $table->integer('order')->nullable();
            $table->integer('cost_per_order')->nullable();
            $table->integer('gross_revenue')->nullable();
            $table->integer('roi')->nullable();

            $table->date('tanggal')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_metrics');
    }
};
