<?php

namespace App\Models;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMetric extends Model
{
    use HasFactory;

    protected $table = 'campaigns';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'Brand_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
