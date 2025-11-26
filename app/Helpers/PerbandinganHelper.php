<?php

namespace App\Helpers;

use App\Models\RiwayatPerbandingan;
use App\Models\Perbandingan;

class PerbandinganHelper
{
    public static function getDetail($perbandingan_id, $jenis, $platform)
    {
        $perbandingan = Perbandingan::find($perbandingan_id);

        $query = RiwayatPerbandingan::where('perbandingan_id', $perbandingan_id)
            ->whereBetween('tanggal', [$perbandingan->tanggal_awal, $perbandingan->tanggal_akhir])
            ->with('Perbandingan')
            ->orderBy('tanggal', 'desc');

        // gmvmax
        if ($platform == 'gmv') {
            $query->where('platform', 'gmvmax');
        }

        // tiktok && initiate
        if ($platform == 'tiktok' && $jenis == 'initiate') {
            $query->where('platform', 'tiktok');
            $query->where('jenis_campaign', 'initiate');
        }

        // tiktok && reach
        if ($platform == 'tiktok' && $jenis == 'reach') {
            $query->where('platform', 'tiktok');
            $query->where('jenis_campaign', 'reach');
        }

        // tiktok && video view
        if ($platform == 'tiktok' && $jenis == 'videoview') {
            $query->where('platform', 'tiktok');
            $query->where('jenis_campaign', 'videoview');
        }

        $data = $query->get();

        return $data;
    }

    public static function hitungPerubahanFooter($riwayat, $jenis, $platform)
    {
        if ($riwayat->count() < 2) {
            return [
                'cost' => 0,
                'impression' => 0,
                'click' => 0,
                'ctr' => 0,
                'cpc' => 0,
                'page_view' => 0,
                'cpv' => 0,
                'initiate' => 0,
                'cost_initiate' => 0,
                'convertion_rate' => 0,
                'order' => 0,
                'cost_per_order' => 0,
                'gross_revenue' => 0,
                'roi' => 0,
            ];
        }


        $oldest = $riwayat->last();   // data paling lama
        $latest = $riwayat->first();  // data terbaru

        $hitung = function ($now, $old) {
            if ($old == 0) return 0;
            return round((($now - $old) / $old) * 100, 1);
        };

        if ($platform == 'tiktok') {
            return [
                'cost'             =>  $hitung($latest->cost, $oldest->cost),
                'impression'       =>  $hitung($latest->impression, $oldest->impression),
                'click'            =>  $hitung($latest->click, $oldest->click),
                'ctr'              =>  $hitung($latest->ctr, $oldest->ctr),
                'cpc'              =>  $hitung($latest->cpc, $oldest->cpc),
                'page_view'        =>  $hitung($latest->page_view, $oldest->page_view),
                'cpv'              =>  $hitung($latest->cpv, $oldest->cpv),
                'initiate'         =>  $hitung($latest->initiate, $oldest->initiate),
                'cost_initiate'    =>  $hitung($latest->cost_initiate, $oldest->cost_initiate),
                'convertion_rate'  =>  $hitung($latest->convertion_rate, $oldest->convertion_rate),
            ];
        }

        if ($platform == 'gmvmax') {
            return [
                'cost'              => $hitung($latest->cost, $oldest->cost),
                'order'             => $hitung($latest->order, $oldest->order),
                'cost_per_order'    => $hitung($latest->cost_per_order, $oldest->cost_per_order),
                'gross_revenue'     => $hitung($latest->gross_revenue, $oldest->gross_revenue),
                'roi'               => $hitung($latest->roi, $oldest->roi),
            ];
        }
    }
}
