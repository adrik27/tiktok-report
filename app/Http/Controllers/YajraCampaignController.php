<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class YajraCampaignController
{
    public function tampil_data()
    {
        $campaign = Campaign::where('User_id', Auth::user()->id)->pluck('id');

        $campaignMetrix = CampaignMetric::whereIn('Campaign_id', $campaign)->with('Campaign')->get();

        return DataTables::of($campaignMetrix)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return ucwords($row->campaign->Brand->nama);
            })
            ->addColumn('tanggal', function ($row) {
                return date('d M Y', strtotime($row->campaign->tanggal));
            })
            ->addColumn('action', function ($row) {
                // <button class="btn btn-sm btn-warning" data-id="' . $row->id . '" data-name="' . $row->nama . '">Edit</button>
                return '
                    <button class="btn btn-sm btn-danger deleteCampaignBtn" data-id="' . $row->id . '">Hapus</button>
                ';
            })
            ->rawColumns(['action', 'tanggal', 'nama'])
            ->make(true);
    }
}
