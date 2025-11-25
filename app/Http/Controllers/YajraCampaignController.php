<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class YajraCampaignController
{
    public function tampil_data(Request $post)
    {

        if ($post->ajax()) {

            $campaignMetrix = CampaignMetric::where('user_id', Auth::id())->with('User', 'Brand')->get();

            return DataTables::of($campaignMetrix)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return ucwords($row->Brand->nama);
                })
                ->addColumn('tanggal', function ($row) {
                    return date('d M Y', strtotime($row->tanggal));
                })
                ->addColumn('cost', function ($row) {
                    return formatAngka($row->cost);
                })
                ->addColumn('cpm', function ($row) {
                    return formatAngka($row->cpm);
                })
                ->addColumn('impression', function ($row) {
                    return formatAngka($row->impression);
                })
                ->addColumn('klik', function ($row) {
                    return formatAngka($row->klik);
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
                ->addColumn('cost_per_initiate', function ($row) {
                    return formatAngka($row->cost_per_initiate);
                })
                ->addColumn('result', function ($row) {
                    return formatAngka($row->result);
                })
                ->addColumn('cpr', function ($row) {
                    return formatAngka($row->cpr);
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
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex justify-content-center gap-2">
                                <a href="' . url('/campaign/' . $row->id . '/edit') . '" 
                                class="btn btn-sm btn-warning">
                                Edit
                                </a>
                                <button class="btn btn-sm btn-danger deleteCampaignBtn" 
                                        data-id="' . $row->id . '">
                                    Hapus
                                </button>
                            </div>
                        ';
                })


                ->rawColumns(['action', 'tanggal', 'nama', 'cost', 'cpm', 'impression', 'klik', 'cpc', 'page_view', 'cpv', 'initiate', 'cost_per_initiate', 'result', 'cpr', 'order', 'cost_per_order', 'gross_revenue', 'roi'])
                ->make(true);
        }
    }
}
