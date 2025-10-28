<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\CampaignMetric;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{

    use HasFactory;

    protected $table = 'campaigns';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'User_id');
    }

    public function Brand()
    {
        return $this->belongsTo(Brand::class, 'Brand_id');
    }

    public function Metrics()
    {
        return $this->hasMany(CampaignMetric::class);
    }
}
