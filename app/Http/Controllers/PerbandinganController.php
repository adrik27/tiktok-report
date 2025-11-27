<?php

namespace App\Http\Controllers;

use App\Helpers\PerbandinganHelper;
use App\Models\Brand;
use App\Models\CampaignMetric;
use App\Models\Perbandingan;
use App\Models\RiwayatPerbandingan;
use Illuminate\Http\Request;
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
            'files' => 'mimes:jpg,jpeg,png,gif,webp,svg|max:2048',
        ]);

        // cek apakah ada metric dalam rentang tanggal
        $cekMetrik = CampaignMetric::where('brand_id', $request->brand_id)
            ->where('user_id', Auth::id())
            ->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
            ->exists();

        if (!$cekMetrik) {
            return back()->with('error', 'Data campaign tidak ada !');
        }

        // cek apakah sudah pernah dibuat
        $perbandingan = Perbandingan::where('brand_id', $request->brand_id)
            ->where(function ($q) use ($request) {
                $q->where('tanggal_awal', '<=', $request->tanggal_akhir)
                    ->where('tanggal_akhir', '>=', $request->tanggal_awal);
            })
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

        // ambil metrik per tanggal
        $metrics = CampaignMetric::selectRaw("
                    tanggal,
                    platform,
                    jenis_campaign,
                    SUM(cost) as total_cost,

                    SUM(impression) as total_impression,
                    SUM(klik) as total_click,
                    SUM(cpc) as total_cpc,
                    SUM(page_view) as total_page_view,
                    SUM(cpv) as total_cpv,
                    SUM(initiate) as total_initiate,

                    SUM(`order`) as total_order,
                    SUM(cost_per_order) as total_cost_per_order,
                    SUM(gross_revenue) as total_gross_revenue,
                    SUM(roi) as total_roi
                ")
            ->where('brand_id', $perbandingan->brand_id)
            ->whereBetween('tanggal', [$perbandingan->tanggal_awal, $perbandingan->tanggal_akhir])
            ->groupBy('tanggal', 'platform', 'jenis_campaign')
            ->orderBy('tanggal')
            ->get();

        // simpan riwayat
        foreach ($metrics as $m) {

            // cek apakah record untuk tanggal + platform + jenis_campaign sudah ada
            $cek = RiwayatPerbandingan::where('perbandingan_id', $perbandingan->id)
                ->where('tanggal', $m->tanggal)
                ->where('platform', $m->platform)
                ->where('jenis_campaign', $m->jenis_campaign)
                ->first();

            $ctr = ($m->total_impression > 0)
                ? round(($m->total_click / $m->total_impression) * 100, 2)
                : 0;

            $cost_initiate = ($m->total_initiate > 0)
                ? round($m->total_cost / $m->total_initiate, 2)
                : 0;

            $conversion_rate = ($m->total_click > 0)
                ? round(($m->total_initiate / $m->total_click) * 100, 2)
                : 0;

            $dataUpdate = [
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
                'order' => $m->total_order,
                'cost_per_order' => $m->total_cost_per_order,
                'gross_revenue' => $m->total_gross_revenue,
                'roi' => $m->total_roi,
            ];

            if ($cek) {
                // UPDATE jika sudah ada
                $cek->update($dataUpdate);
            } else {

                RiwayatPerbandingan::create([
                    'perbandingan_id' => $perbandingan->id ?? null,
                    'tanggal' => $m->tanggal ?? null,
                    'platform' => $m->platform ?? null,
                    'jenis_campaign' => $m->jenis_campaign ?? null,
                    'cost' => $m->total_cost ?? null,
                    'impression' => $m->total_impression ?? null,
                    'click' => $m->total_click ?? null,
                    'cpc' => $m->total_cpc ?? null,
                    'page_view' => $m->total_page_view ?? null,
                    'cpv' => $m->total_cpv ?? null,
                    'initiate' => $m->total_initiate ?? null,
                    'ctr' => $ctr ?? null,
                    'cost_initiate' => $cost_initiate ?? null,
                    'convertion_rate' => $conversion_rate ?? null,
                    'order' => $m->total_order ?? null,
                    'cost_per_order' => $m->total_cost_per_order ?? null,
                    'gross_revenue' => $m->total_gross_revenue ?? null,
                    'roi' => $m->total_roi ?? null
                ]);
            }
        }


        return back()->with('success', 'Perbandingan berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $perbandingan = Perbandingan::find($id);


        if ($perbandingan) {
            // handle upload
            if ($request->hasFile('files')) {
                $file = $request->file('files');
                $fileName = 'perbandingan/' . time() . '_' . $perbandingan->Brand->nama . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put($fileName, file_get_contents($file));
                $localPath = '/storage/' . $fileName;
            } else {
                if ($perbandingan->files !== null) {
                    $localPath = $perbandingan->files;
                } else {
                    $localPath = null;
                }
            }

            $perbandingan->update([
                'summary'   => $request->summary,
                'planning'  => $request->planning,
                'files'     => $localPath
            ]);

            return back()->with('success', 'Perbandingan berhasil diupdate!');
        } else {
            return back()->with('error', 'Perbandingan gagal diupdate!');
        }
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

        $count['initiate'] = RiwayatPerbandingan::where('perbandingan_id', $id)
            ->where('jenis_campaign', 'initiate')->count();
        $count['videoview'] = RiwayatPerbandingan::where('perbandingan_id', $id)
            ->where('jenis_campaign', 'videoview')->count();
        $count['reach'] = RiwayatPerbandingan::where('perbandingan_id', $id)
            ->where('jenis_campaign', 'reach')->count();
        $count['gmvmax'] = RiwayatPerbandingan::where('perbandingan_id', $id)
            ->where('platform', 'gmvmax')->count();

        return view('admin.perbandingan.detail', [
            'title'                 => 'Detail Perbandingan',
            'RiwayatPerbandingan'   => $RiwayatPerbandingan,
            'data_count'            => $count,
        ]);
    }

    public function cetak($id)
    {
        $perbandingan = Perbandingan::where('id', $id)->first();

        $initiate    = PerbandinganHelper::getDetail($id, 'initiate', 'tiktok');
        $reach       = PerbandinganHelper::getDetail($id, 'reach', 'tiktok');
        $videoview   = PerbandinganHelper::getDetail($id, 'videoview', 'tiktok');
        $gmv         = PerbandinganHelper::getDetail($id, null, 'gmv');

        // ===== HITUNG FOOTER PERUBAHAN =====
        $footer = [
            'initiate'  => PerbandinganHelper::hitungPerubahanFooter($initiate, 'initiate', 'tiktok'),
            'reach'     => PerbandinganHelper::hitungPerubahanFooter($reach, 'reach', 'tiktok'),
            'videoview' => PerbandinganHelper::hitungPerubahanFooter($videoview, 'videoview', 'tiktok'),
            'gmv'       => PerbandinganHelper::hitungPerubahanFooter($gmv, null, 'gmvmax'),
        ];
        // dd($footer);
        $count = [
            'initiate'  => $initiate->count(),
            'reach'     => $reach->count(),
            'videoview' => $videoview->count(),
            'gmvmax'    => $gmv->count(),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.perbandingan.cetak', [
            'title'        => 'Cetak Perbandingan',
            'perbandingan' => $perbandingan,
            'initiate'     => $initiate,
            'reach'        => $reach,
            'videoview'    => $videoview,
            'gmv'          => $gmv,
            'data_count'   => $count,
            'footer'       => $footer,
        ])->setPaper('A4', 'landscape');

        $name = time() . '_' . date('Y-m-d') . '_' . strtolower($perbandingan->Brand->nama) . '_perbandingan.pdf';
        return $pdf->stream($name);
    }

    public function share($id)
    {
        $perbandingan = Perbandingan::where('id', $id)->first();

        $initiate    = PerbandinganHelper::getDetail($id, 'initiate', 'tiktok');
        $reach       = PerbandinganHelper::getDetail($id, 'reach', 'tiktok');
        $videoview   = PerbandinganHelper::getDetail($id, 'videoview', 'tiktok');
        $gmv         = PerbandinganHelper::getDetail($id, null, 'gmv');

        // ===== HITUNG FOOTER PERUBAHAN =====
        $footer = [
            'initiate'  => PerbandinganHelper::hitungPerubahanFooter($initiate, 'initiate', 'tiktok'),
            'reach'     => PerbandinganHelper::hitungPerubahanFooter($reach, 'reach', 'tiktok'),
            'videoview' => PerbandinganHelper::hitungPerubahanFooter($videoview, 'videoview', 'tiktok'),
            'gmv'       => PerbandinganHelper::hitungPerubahanFooter($gmv, null, 'gmvmax'),
        ];

        $count = [
            'initiate'  => $initiate->count(),
            'reach'     => $reach->count(),
            'videoview' => $videoview->count(),
            'gmvmax'    => $gmv->count(),
        ];

        return view('admin.perbandingan.share', [
            'title'        => 'Share Perbandingan',
            'perbandingan' => $perbandingan,
            'initiate'     => $initiate,
            'reach'        => $reach,
            'videoview'    => $videoview,
            'gmv'          => $gmv,
            'data_count'   => $count,
            'footer'       => $footer,
        ]);

        // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.perbandingan.cetak', [
        //     'title'        => 'Cetak Perbandingan',
        //     'perbandingan' => $perbandingan,
        //     'initiate'     => $initiate,
        //     'reach'        => $reach,
        //     'videoview'    => $videoview,
        //     'gmv'          => $gmv,
        //     'data_count'   => $count,
        //     'footer'       => $footer,
        // ])->setPaper('A4', 'landscape');

        // $name = time() . '_' . date('Y-m-d') . '_' . strtolower($perbandingan->Brand->nama) . '_perbandingan.pdf';
        // return $pdf->stream($name);
    }
}
