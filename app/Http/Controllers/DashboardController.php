<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CampaignMetric;
use App\Models\Perbandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController
{
    public function index()
    {
        $counting = [
            'brand' => Brand::where('User_id', Auth::user()->id)->count(),
            'campaign' => CampaignMetric::where('user_id', Auth::user()->id)
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->count(),
            'perbandingan' => Perbandingan::where('user_id', Auth::user()->id)
                ->whereMonth('tanggal_awal', date('m'))
                ->whereYear('tanggal_awal', date('Y'))
                ->whereMonth('tanggal_akhir', date('m'))
                ->whereYear('tanggal_akhir', date('Y'))
                ->select('brand_id', DB::raw('COUNT(*) as total'))
                ->groupBy('brand_id')
                ->get()
                ->count()
        ];

        $brands = Brand::where('User_id', Auth::user()->id)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->with('User')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $campaigns = CampaignMetric::where('user_id', Auth::user()->id)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        $perbandingans = Perbandingan::where('user_id', Auth::user()->id)
            ->whereMonth('tanggal_awal', date('m'))
            ->whereYear('tanggal_awal', date('Y'))
            ->whereMonth('tanggal_akhir', date('m'))
            ->whereYear('tanggal_akhir', date('Y'))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', [
            'title' => 'Dashboard',
            'count' => $counting,
            'brands' => $brands,
            'campaigns' => $campaigns,
            'perbandingans' => $perbandingans
        ]);
    }
}
