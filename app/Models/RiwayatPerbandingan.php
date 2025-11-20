<?php

namespace App\Models;

use App\Models\Perbandingan;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerbandingan extends Model
{
    protected $table = 'riwayat_perbandingans';
    protected $guarded = ['id'];
    public function Perbandingan()
    {
        return $this->belongsTo(Perbandingan::class, 'perbandingan_id', 'id');
    }
}
