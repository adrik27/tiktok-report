<?php

namespace App\Models;

use App\Models\CampaignMetric;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $guarded = ['id'];


    public function Campaign()
    {
        return $this->hasMany(CampaignMetric::class, 'brand_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'User_id');
    }
}
