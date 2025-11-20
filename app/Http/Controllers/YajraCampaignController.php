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


                ->rawColumns(['action', 'tanggal', 'nama'])
                ->make(true);
        }
    }
}
