<?php

namespace App\Models;

use App\Models\User;
use App\Models\RiwayatPerbandingan;
use Illuminate\Database\Eloquent\Model;

class Perbandingan extends Model
{
    protected $table = 'perbandingans';
    protected $guarded = ['id'];

    public function Riwayat()
    {
        return $this->hasMany(RiwayatPerbandingan::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
