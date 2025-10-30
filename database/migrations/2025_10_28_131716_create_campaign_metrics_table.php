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
            // $table->enum('platform', ['tiktok', 'gmvmax']);

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

            $table->integer('impression_gmvmax')->nullable();
            $table->integer('reach_gmvmax')->nullable();
            $table->integer('klik_gmvmax')->nullable();
            $table->decimal('ctr_gmvmax', 10, 2)->nullable();
            $table->integer('cpc_gmvmax')->nullable();
            $table->integer('atc_gmvmax')->nullable();
            $table->integer('cost_atc_gmvmax')->nullable();
            $table->integer('ic_gmvmax')->nullable();
            $table->integer('purchase_gmvmax')->nullable();
            $table->decimal('conversion_rate_gmvmax', 10, 2)->nullable();
            $table->integer('total_spend_gmvmax')->nullable();
            $table->integer('roas_gmvmax')->nullable();
            $table->integer('roi_gmvmax')->nullable();

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
