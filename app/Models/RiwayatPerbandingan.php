<?php

namespace App\Models;

use App\Models\CampaignMetric;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerbandingan extends Model
{
    protected $table = 'riwayat_perbandingans';
    protected $guarded = ['id'];
    public function metrics()
    {
        return $this->belongsTo(CampaignMetric::class, 'campaign_metrics_id', 'id');
    }
}
