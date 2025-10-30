<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMetric extends Model
{
    use HasFactory;

    protected $table = 'campaign_metrics';
    protected $guarded = ['id'];

    public function Brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
