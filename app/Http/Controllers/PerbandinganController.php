<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Perbandingan;
use Illuminate\Http\Request;
use App\Models\CampaignMetric;
use App\Models\RiwayatPerbandingan;
use Illuminate\Support\Facades\Auth;

class PerbandinganController
{
    public function index()
    {
        return view('admin.perbandingan.index', [
            'title'     => 'Perbandingan',
            'brands'    => Brand::where('User_id', Auth::user()->id)->with('User')->get()
            // 'campaign'  => CampaignMetric::where('user_id', Auth::user()->id)->with('User', 'Brand')->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function perbandingan(Request $request)
    {
        // validasi
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        // 1. simpan ke tabel perbandingans
        $perbandingan = Perbandingan::create([
            'brand_id'      => $request->brand_id,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'user_id'       => Auth::id(),
        ]);

        // 2. AMBIL & GROUP BY TANGGAL
        $metrics = CampaignMetric::selectRaw("
            tanggal,
            SUM(cost) as total_cost,
            SUM(impression) as total_impression,
            SUM(klik) as total_click,
            SUM(page_view) as total_page_view,
            SUM(initiate) as total_initiate
        ")
            ->where('brand_id', $request->brand_id)
            ->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // 3. SIMPAN HASIL YANG SUDAH DIJUMLAHKAN
        foreach ($metrics as $m) {

            // hitung metrik turunan
            $ctr = ($m->total_impression > 0)
                ? round(($m->total_click / $m->total_impression) * 100, 2)
                : 0;

            $cpc = ($m->total_click > 0)
                ? round($m->total_cost / $m->total_click)
                : 0;

            $cpv = ($m->total_page_view > 0)
                ? round($m->total_cost / $m->total_page_view)
                : 0;

            $cost_initiate = ($m->total_initiate > 0)
                ? round($m->total_cost / $m->total_initiate)
                : 0;

            // simpan ke tabel perbandingan_results
            RiwayatPerbandingan::create([
                'perbandingan_id' => $perbandingan->id,
                'tanggal'         => $m->tanggal,
                'impression'      => $m->total_impression,
                'click'           => $m->total_click,
                'page_view'       => $m->total_page_view,
                'initiate'        => $m->total_initiate,
                'cost'            => $m->total_cost,
                'ctr'             => $ctr,
                'cpc'             => $cpc,
                'cpv'             => $cpv,
                'cost_initiate'   => $cost_initiate,
            ]);
        }

        return redirect()->back()->with('success', 'Perbandingan berhasil dibuat!');
    }
}
