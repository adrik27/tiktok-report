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

        $cekData = Perbandingan::where('brand_id', $request->brand_id)
            ->where('tanggal_awal', $request->tanggal_awal)
            ->where('tanggal_akhir', $request->tanggal_akhir)
            ->where('user_id', Auth::id())
            ->first();

        if ($cekData) {
            return redirect()->back()->with('error', 'Data perbandingan sudah ada');
        }

        if ($request->hasFile('files')) {
            $cariBrand = Brand::where('id', $request->brand_id)->first();
            $image = $request->file('files');
            $imageContents = file_get_contents($image->getRealPath());
            $fileName = 'perbandingan/' . rand(1000, 9999) . '_' . $cariBrand->nama . '.jpg';
            Storage::disk('public')->put($fileName, $imageContents);
            $localPath = '/storage/' . $fileName;
        }

        // 1. simpan ke tabel perbandingans
        $perbandingan = Perbandingan::create([
            'brand_id'      => $request->brand_id,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'user_id'       => Auth::id(),

            'files'         => $localPath ?? null,
            'summary'       => $request->summary ?? null,
            'planning'      => $request->planning ?? null,
        ]);

        // 2. AMBIL & GROUP BY TANGGAL
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
            ->where('brand_id', $request->brand_id)
            ->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // 3. SIMPAN HASIL YANG SUDAH DIJUMLAHKAN
        foreach ($metrics as $m) {
            // hitung metrik turunan
            if ($m->total_impression > 0 && $m->total_click > 0) {
                $ctr = round(($m->total_click / $m->total_impression) * 100, 2);
            } else {
                $ctr = 0;
            }

            if ($m->total_cost > 0 && $m->total_initiate > 0) {
                $cost_initiate = round(($m->total_cost / $m->total_initiate) * 100, 2);
            } else {
                $cost_initiate = 0;
            }

            if ($m->total_click > 0 && $m->total_initiate > 0) {
                $convertion_rate = round(($m->total_click / $m->total_initiate) * 100, 2);
            } else {
                $convertion_rate = 0;
            }

            // simpan ke tabel perbandingan_results
            RiwayatPerbandingan::create([
                'perbandingan_id'   => $perbandingan->id,
                'cost'              => $m->total_cost,
                'impression'        => $m->total_impression,
                'click'             => $m->total_click,
                'cpc'               => $m->total_cpc,
                'page_view'         => $m->total_page_view,
                'cpv'               => $m->total_cpv,
                'initiate'          => $m->total_initiate,

                'ctr'               => $ctr,
                'cost_initiate'     => $cost_initiate,
                'convertion_rate'   => $convertion_rate,
            ]);
        }

        return redirect()->back()->with('success', 'Perbandingan berhasil dibuat!');
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
