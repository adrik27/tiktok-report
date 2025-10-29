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
            $table->foreignId('campaign_id');
            $table->enum('platform', ['tiktok', 'gmvmax']);

            $table->integer('impression')->nullable();
            $table->integer('reach')->nullable();
            $table->integer('klik')->nullable();
            $table->decimal('ctr', 10, 2)->nullable();
            $table->integer('cpc')->nullable();
            $table->integer('atc')->nullable();
            $table->integer('cost_atc')->nullable();
            $table->integer('ic')->nullable();
            $table->integer('purchase')->nullable();
            $table->decimal('conversion_rate', 10, 2)->nullable();
            $table->integer('total_spend')->nullable();
            $table->integer('roas')->nullable();
            $table->integer('roi')->nullable();

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
