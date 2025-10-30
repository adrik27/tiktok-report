<?php

namespace App\Models;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMetric extends Model
{
    use HasFactory;

    protected $table = 'campaign_metrics';
    protected $guarded = ['id'];

    public function Campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}
