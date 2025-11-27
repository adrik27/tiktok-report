<?php

namespace App\Http\Controllers;

use App\Models\Perbandingan;
use Illuminate\Http\Request;
use App\Models\RiwayatPerbandingan;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\PerbandinganHelper;

class YajraPerbandinganController
{
    public function tampil_data(Request $post)
    {

        if ($post->ajax()) {

            $perbandingan = Perbandingan::where('user_id', Auth::id())->with('User', 'Brand')->get();

            return DataTables::of($perbandingan)
                ->addIndexColumn()
                ->addColumn('files', function ($row) {
                    if ($row->files) {
                        $link = $row->files;
                        $linksHtml = '<a href="' . asset($link) . '" target="_blank">' . $row->Brand->nama . '</a>';
                        return $linksHtml;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('brand', function ($row) {
                    return ucwords($row->Brand->nama);
                })
                ->addColumn('tanggal_awal', function ($row) {
                    return date('d M Y', strtotime($row->tanggal_awal));
                })
                ->addColumn('tanggal_akhir', function ($row) {
                    return date('d M Y', strtotime($row->tanggal_akhir));
                })
                ->addColumn('action', function ($row) {

                    $shareUrl = url('/perbandingan/' . $row->id . '/share');

                    return '
                        <div class="d-flex justify-content-start gap-1">

                            <a href="' . url('/perbandingan/' . $row->id . '/detail') . '" 
                                class="btn btn-sm btn-primary">Detail</a>

                            <a href="' . url('/perbandingan/' . $row->id . '/cetak') . '" 
                                class="btn btn-sm btn-success">Cetak</a>

                            <a href="javascript:void(0)" 
                                class="btn btn-sm btn-warning"
                                onclick="shareLink(\'Perbandingan\', \'Bagikan link perbandingan\', \'' . $shareUrl . '\')">
                                Share
                            </a>

                            <button class="btn btn-sm btn-danger deletePerbandinganBtn" 
                                data-id="' . $row->id . '">Hapus</button>

                        </div>
                    ';
                })

                ->rawColumns(['action', 'brand', 'tanggal_awal', 'tanggal_akhir', 'files'])
                ->make(true);
        }
    }

    public function tampil_data_detail_initiate(Request $post)
    {
        if ($post->ajax()) {
            $perbandingan = Perbandingan::where('id', $post->perbandingan_id)
                ->first();

            $riwayat_perbandingan = PerbandinganHelper::getDetail($perbandingan->id, 'initiate', 'tiktok');

            // ==== HITUNG PERUBAHAN DINAMIS ====
            if ($riwayat_perbandingan->count() >= 2) {

                $oldest = $riwayat_perbandingan->last();       // data paling lama
                $latest = $riwayat_perbandingan->first();      // data terbaru

                function perubahan($now, $old)
                {
                    if ($old == 0) return 0;
                    return (($now - $old) / $old) * 100;
                }

                $footer = [
                    'cost'             => perubahan($latest->cost, $oldest->cost),
                    'impression'       => perubahan($latest->impression, $oldest->impression),
                    'click'            => perubahan($latest->click, $oldest->click),
                    'ctr'              => perubahan($latest->ctr, $oldest->ctr),
                    'cpc'              => perubahan($latest->cpc, $oldest->cpc),
                    'page_view'        => perubahan($latest->page_view, $oldest->page_view),
                    'cpv'              => perubahan($latest->cpv, $oldest->cpv),
                    'initiate'         => perubahan($latest->initiate, $oldest->initiate),
                    'cost_initiate'    => perubahan($latest->cost_initiate, $oldest->cost_initiate),
                    'convertion_rate'  => perubahan($latest->convertion_rate, $oldest->convertion_rate),
                ];
            } else {
                $footer = [];
            }

            return DataTables::of($riwayat_perbandingan)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    return formatTanggal($row->tanggal);
                })
                ->addColumn('cost', function ($row) {
                    return formatAngka($row->cost);
                })
                ->addColumn('impression', function ($row) {
                    return formatAngka($row->impression);
                })
                ->addColumn('click', function ($row) {
                    return formatAngka($row->click);
                })
                ->addColumn('ctr', function ($row) {
                    return formatPercentase($row->ctr);
                })
                ->addColumn('cpc', function ($row) {
                    return formatAngka($row->cpc);
                })
                ->addColumn('page_view', function ($row) {
                    return formatAngka($row->page_view);
                })
                ->addColumn('cpv', function ($row) {
                    return formatAngka($row->cpv);
                })
                ->addColumn('initiate', function ($row) {
                    return formatAngka($row->initiate);
                })
                ->addColumn('cost_initiate', function ($row) {
                    return formatAngka($row->cost_initiate);
                })
                ->addColumn('convertion_rate', function ($row) {
                    return formatPercentase($row->convertion_rate);
                })
                ->with('footer', $footer)
                ->rawColumns(['tanggal', 'cost', 'impression', 'click', 'ctr', 'cpc', 'page_view', 'cpv', 'initiate', 'cost_initiate', 'convertion_rate'])
                ->make(true);
        }
    }

    public function tampil_data_detail_reach(Request $post)
    {
        if ($post->ajax()) {
            $perbandingan = Perbandingan::where('id', $post->perbandingan_id)
                ->first();

            $riwayat_perbandingan = PerbandinganHelper::getDetail($perbandingan->id, 'reach', 'tiktok');

            // ==== HITUNG PERUBAHAN DINAMIS ====
            if ($riwayat_perbandingan->count() >= 2) {

                $oldest = $riwayat_perbandingan->last();       // data paling lama
                $latest = $riwayat_perbandingan->first();      // data terbaru

                function perubahan($now, $old)
                {
                    if ($old == 0) return 0;
                    return (($now - $old) / $old) * 100;
                }

                $footer = [
                    'cost'             => perubahan($latest->cost, $oldest->cost),
                    'impression'       => perubahan($latest->impression, $oldest->impression),
                    'click'            => perubahan($latest->click, $oldest->click),
                    'ctr'              => perubahan($latest->ctr, $oldest->ctr),
                    'cpc'              => perubahan($latest->cpc, $oldest->cpc),
                    'page_view'        => perubahan($latest->page_view, $oldest->page_view),
                    'cpv'              => perubahan($latest->cpv, $oldest->cpv),
                    'initiate'         => perubahan($latest->initiate, $oldest->initiate),
                    'cost_initiate'    => perubahan($latest->cost_initiate, $oldest->cost_initiate),
                    'convertion_rate'  => perubahan($latest->convertion_rate, $oldest->convertion_rate),
                ];
            } else {
                $footer = [];
            }

            return DataTables::of($riwayat_perbandingan)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    return formatTanggal($row->tanggal);
                })
                ->addColumn('cost', function ($row) {
                    return formatAngka($row->cost);
                })
                ->addColumn('impression', function ($row) {
                    return formatAngka($row->impression);
                })
                ->addColumn('click', function ($row) {
                    return formatAngka($row->click);
                })
                ->addColumn('ctr', function ($row) {
                    return formatPercentase($row->ctr);
                })
                ->addColumn('cpc', function ($row) {
                    return formatAngka($row->cpc);
                })
                ->addColumn('page_view', function ($row) {
                    return formatAngka($row->page_view);
                })
                ->addColumn('cpv', function ($row) {
                    return formatAngka($row->cpv);
                })
                ->addColumn('initiate', function ($row) {
                    return formatAngka($row->initiate);
                })
                ->addColumn('cost_initiate', function ($row) {
                    return formatAngka($row->cost_initiate);
                })
                ->addColumn('convertion_rate', function ($row) {
                    return formatPercentase($row->convertion_rate);
                })
                ->with('footer', $footer)
                ->rawColumns(['tanggal', 'cost', 'impression', 'click', 'ctr', 'cpc', 'page_view', 'cpv', 'initiate', 'cost_initiate', 'convertion_rate'])
                ->make(true);
        }
    }

    public function tampil_data_detail_videoview(Request $post)
    {
        if ($post->ajax()) {
            $perbandingan = Perbandingan::where('id', $post->perbandingan_id)
                ->first();

            $riwayat_perbandingan = PerbandinganHelper::getDetail($perbandingan->id, 'videoview', 'tiktok');

            // ==== HITUNG PERUBAHAN DINAMIS ====
            if ($riwayat_perbandingan->count() >= 2) {

                $oldest = $riwayat_perbandingan->last();       // data paling lama
                $latest = $riwayat_perbandingan->first();      // data terbaru

                function perubahan($now, $old)
                {
                    if ($old == 0) return 0;
                    return (($now - $old) / $old) * 100;
                }

                $footer = [
                    'cost'             => perubahan($latest->cost, $oldest->cost),
                    'impression'       => perubahan($latest->impression, $oldest->impression),
                    'click'            => perubahan($latest->click, $oldest->click),
                    'ctr'              => perubahan($latest->ctr, $oldest->ctr),
                    'cpc'              => perubahan($latest->cpc, $oldest->cpc),
                    'page_view'        => perubahan($latest->page_view, $oldest->page_view),
                    'cpv'              => perubahan($latest->cpv, $oldest->cpv),
                    'initiate'         => perubahan($latest->initiate, $oldest->initiate),
                    'cost_initiate'    => perubahan($latest->cost_initiate, $oldest->cost_initiate),
                    'convertion_rate'  => perubahan($latest->convertion_rate, $oldest->convertion_rate),
                ];
            } else {
                $footer = [];
            }

            return DataTables::of($riwayat_perbandingan)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    return formatTanggal($row->tanggal);
                })
                ->addColumn('jenis_campaign', function ($row) {
                    if ($row->jenis_campaign == 'videoview') {
                        return 'video view';
                    } else {
                        return $row->jenis_campaign;
                    }
                })
                ->addColumn('cost', function ($row) {
                    return formatAngka($row->cost);
                })
                ->addColumn('impression', function ($row) {
                    return formatAngka($row->impression);
                })
                ->addColumn('click', function ($row) {
                    return formatAngka($row->click);
                })
                ->addColumn('ctr', function ($row) {
                    return formatPercentase($row->ctr);
                })
                ->addColumn('cpc', function ($row) {
                    return formatAngka($row->cpc);
                })
                ->addColumn('page_view', function ($row) {
                    return formatAngka($row->page_view);
                })
                ->addColumn('cpv', function ($row) {
                    return formatAngka($row->cpv);
                })
                ->addColumn('initiate', function ($row) {
                    return formatAngka($row->initiate);
                })
                ->addColumn('cost_initiate', function ($row) {
                    return formatAngka($row->cost_initiate);
                })
                ->addColumn('convertion_rate', function ($row) {
                    return formatPercentase($row->convertion_rate);
                })
                ->with('footer', $footer)
                ->rawColumns(['tanggal', 'jenis_campaign', 'cost', 'impression', 'click', 'ctr', 'cpc', 'page_view', 'cpv', 'initiate', 'cost_initiate', 'convertion_rate'])
                ->make(true);
        }
    }

    public function tampil_data_detail_gmv(Request $post)
    {
        if ($post->ajax()) {
            $perbandingan = Perbandingan::where('id', $post->perbandingan_id)
                ->first();

            $riwayat_perbandingan = PerbandinganHelper::getDetail($perbandingan->id, null, 'gmv');

            // ==== HITUNG PERUBAHAN DINAMIS ====
            if ($riwayat_perbandingan->count() >= 2) {

                $oldest = $riwayat_perbandingan->last();       // data paling lama
                $latest = $riwayat_perbandingan->first();      // data terbaru

                function perubahan($now, $old)
                {
                    if ($old == 0) return 0;
                    return (($now - $old) / $old) * 100;
                }

                $footer = [
                    'cost'              => perubahan($latest->cost, $oldest->cost),
                    'order'             => perubahan($latest->order, $oldest->order),
                    'cost_per_order'    => perubahan($latest->cost_per_order, $oldest->cost_per_order),
                    'gross_revenue'     => perubahan($latest->gross_revenue, $oldest->gross_revenue),
                    'roi'               => perubahan($latest->roi, $oldest->roi),
                ];
            } else {
                $footer = [];
            }

            return DataTables::of($riwayat_perbandingan)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    return formatTanggal($row->tanggal);
                })
                ->addColumn('cost', function ($row) {
                    return formatAngka($row->cost);
                })
                ->addColumn('order', function ($row) {
                    return formatAngka($row->order);
                })
                ->addColumn('cost_per_order', function ($row) {
                    return formatAngka($row->cost_per_order);
                })
                ->addColumn('gross_revenue', function ($row) {
                    return formatAngka($row->gross_revenue);
                })
                ->addColumn('roi', function ($row) {
                    return formatAngka($row->roi);
                })
                ->with('footer', $footer)
                ->rawColumns(['tanggal', 'cost', 'order', 'cost_per_order', 'gross_revenue', 'roi'])
                ->make(true);
        }
    }
}
