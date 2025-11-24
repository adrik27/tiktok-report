<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Perbandingan;
use Illuminate\Http\Request;
use App\Models\CampaignMetric;
use App\Models\RiwayatPerbandingan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerbandinganController
{
    public function index()
    {
        $brand = CampaignMetric::select('brand_id')
            ->where('User_id', Auth::user()->id)
            ->groupBy('brand_id')
            ->with('Brand')
            ->get();

        return view('admin.perbandingan.index', [
            'title'     => 'Perbandingan',
            'brands'    => $brand,
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

        // cek apakah ada metric dalam rentang tanggal
        $cekMetrik = CampaignMetric::where('brand_id', $request->brand_id)
            ->where('user_id', Auth::id())
            ->where('platform', $request->platform)
            ->where('jenis_campaign', $request->jenis_campaign)
            ->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
            ->exists();

        if (!$cekMetrik) {
            return back()->with('error', 'Data campaign tidak ada !');
        }

        // cek apakah sudah pernah dibuat
        $perbandingan = Perbandingan::where('brand_id', $request->brand_id)
            ->where('tanggal_awal', $request->tanggal_awal)
            ->where('tanggal_akhir', $request->tanggal_akhir)
            ->where('user_id', Auth::id())
            ->first();

        // handle upload
        $localPath = null;
        if ($request->hasFile('files')) {
            $brand = Brand::find($request->brand_id);
            $file = $request->file('files');
            $fileName = 'perbandingan/' . time() . '_' . $brand->nama . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($file));
            $localPath = '/storage/' . $fileName;
        }

        // jika belum ada perbandingan → buat baru
        if (!$perbandingan) {
            $perbandingan = Perbandingan::create([
                'brand_id' => $request->brand_id,
                'tanggal_awal' => $request->tanggal_awal,
                'tanggal_akhir' => $request->tanggal_akhir,
                'user_id' => Auth::id(),
                'files' => $localPath,
                'summary' => $request->summary,
                'planning' => $request->planning,
            ]);
        }

        if ($request->platform == 'tiktok') {
            // ambil metrik per tanggal
            $metrics = CampaignMetric::selectRaw("
                    tanggal,
                    SUM(cost) as total_cost,
                    SUM(impression) as total_impression,
                    SUM(klik) as total_click,
                    SUM(cpc) as total_cpc,
                    SUM(page_view) as total_page_view,
                    SUM(cpv) as total_cpv,
                    SUM(initiate) as total_initiate
                ")
                ->where('brand_id', $perbandingan->brand_id)
                ->where('jenis_campaign', $request->jenis_campaign)
                ->where('platform', 'tiktok')
                ->whereBetween('tanggal', [$perbandingan->tanggal_awal, $perbandingan->tanggal_akhir])
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            // simpan riwayat
            foreach ($metrics as $m) {

                $ctr = ($m->total_impression > 0)
                    ? round(($m->total_click / $m->total_impression) * 100, 2)
                    : 0;

                $cost_initiate = ($m->total_initiate > 0)
                    ? round($m->total_cost / $m->total_initiate, 2)
                    : 0;

                $conversion_rate = ($m->total_click > 0)
                    ? round(($m->total_initiate / $m->total_click) * 100, 2)
                    : 0;

                RiwayatPerbandingan::create([
                    'perbandingan_id' => $perbandingan->id,
                    'cost' => $m->total_cost,
                    'impression' => $m->total_impression,
                    'click' => $m->total_click,
                    'cpc' => $m->total_cpc,
                    'page_view' => $m->total_page_view,
                    'cpv' => $m->total_cpv,
                    'initiate' => $m->total_initiate,
                    'ctr' => $ctr,
                    'cost_initiate' => $cost_initiate,
                    'convertion_rate' => $conversion_rate,
                ]);
            }
        } else {
            // ambil metrik per tanggal
            $metrics = CampaignMetric::selectRaw("
                    tanggal,
                    SUM(cost) as total_cost,
                    SUM(order) as total_order,
                    SUM(cost_per_order) as total_cost_per_order,
                    SUM(gross_revenue) as total_gross_revenue,
                    SUM(roi) as total_roi,
                ")
                ->where('brand_id', $perbandingan->brand_id)
                ->where('jenis_campaign', $request->jenis_campaign)
                ->where('platform', 'gmvmax')
                ->whereBetween('tanggal', [$perbandingan->tanggal_awal, $perbandingan->tanggal_akhir])
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            // simpan riwayat
            foreach ($metrics as $m) {

                RiwayatPerbandingan::create([
                    'perbandingan_id' => $perbandingan->id,
                    'cost' => $m->total_cost,
                    'order' => $m->total_order,
                    'cost_per_order' => $m->total_cost_per_order,
                    'gross_revenue' => $m->total_gross_revenue,
                    'roi' => $m->total_roi
                ]);
            }
        }


        return back()->with('success', 'Perbandingan berhasil dibuat!');
    }


    public function hapus($id)
    {
        $perbandingan = Perbandingan::find($id);
        if ($perbandingan) {
            $riwayatPerbandingan = RiwayatPerbandingan::where('perbandingan_id', $id)->get();

            foreach ($riwayatPerbandingan as $r) {
                $r->delete();
            }

            $perbandingan->delete();

            return response()->json(['success' => true, 'message' => 'Data perbandingan dan riwayatnya berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data perbandingan tidak ditemukan.']);
        }
    }

    public function detail($id)
    {
        $RiwayatPerbandingan = RiwayatPerbandingan::where('perbandingan_id', $id)
            ->with('Perbandingan')
            ->get();

        return view('admin.perbandingan.detail', [
            'title'         => 'Detail Perbandingan',
            'RiwayatPerbandingan'  => $RiwayatPerbandingan,
        ]);
    }
}
