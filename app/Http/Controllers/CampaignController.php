<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CampaignMetric;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        return view('admin.campaign.index', [
            'title' => 'Campaign',
            'campaigns' => Campaign::where('User_id', Auth::user()->id)->with('User', 'Brand', 'Metrics')->get()
        ]);
    }

    public function create()
    {
        return view('admin.campaign.create', [
            'title' => 'Campaign Create',
            'brands' => Brand::where('User_id', Auth::user()->id)->with('User')->get()
        ]);
    }

    public function proses_create(Request $request)
    {
        // Validasi input
        $request->validate([
            'impression'                => 'required',
            'reach'                     => 'required',
            'klik'                      => 'required',
            'ctr'                       => 'required',
            'cpc'                       => 'required',
            'atc'                       => 'required',
            'cost_atc'                  => 'required',
            'ic'                        => 'required',
            'purchase'                  => 'required',
            'conversion_rate'           => 'required',
            'total_spend'               => 'required',
            'roas'                      => 'required',
            'impression_gmvmax'         => 'required',
            'reach_gmvmax'              => 'required',
            'klik_gmvmax'               => 'required',
            'ctr_gmvmax'                => 'required',
            'cpc_gmvmax'                => 'required',
            'atc_gmvmax'                => 'required',
            'cost_atc_gmvmax'           => 'required',
            'ic_gmvmax'                 => 'required',
            'purchase_gmvmax'           => 'required',
            'conversion_rate_gmvmax'    => 'required',
            'total_spend_gmvmax'        => 'required',
            'roas_gmvmax'               => 'required',
        ]);

        try {
            $campaign = [
                'Brand_id' => $request->Brand_id,
                'User_id' => Auth::id(),
            ];

            $saveCampaign = Campaign::create($campaign);
            // Simpan data TikTok
            CampaignMetric::create([
                'campaign_id'      => $saveCampaign->id,
                'platform'         => 'tiktok',
                'impression'       => $request->impression,
                'reach'            => $request->reach,
                'klik'             => $request->klik,
                'ctr'              => $request->ctr,
                'cpc'              => $request->cpc,
                'atc'              => $request->atc,
                'cost_atc'         => $request->cost_atc,
                'ic'               => $request->ic,
                'purchase'         => $request->purchase,
                'conversion_rate'  => $request->conversion_rate,
                'total_spend'      => $request->total_spend,
                'roas'             => $request->roas,
            ]);

            // Simpan data GMV Max
            CampaignMetric::create([
                'campaign_id'      => $saveCampaign->id,
                'platform'         => 'gmvmax',
                'impression'       => $request->impression_gmvmax,
                'reach'            => $request->reach_gmvmax,
                'klik'             => $request->klik_gmvmax,
                'ctr'              => $request->ctr_gmvmax,
                'cpc'              => $request->cpc_gmvmax,
                'atc'              => $request->atc_gmvmax,
                'cost_atc'         => $request->cost_atc_gmvmax,
                'ic'               => $request->ic_gmvmax,
                'purchase'         => $request->purchase_gmvmax,
                'conversion_rate'  => $request->conversion_rate_gmvmax,
                'total_spend'      => $request->total_spend_gmvmax,
                'roas'             => $request->roas_gmvmax,
                'roi'              => $request->roi_gmvmax
            ]);

            // Kembalikan response JSON untuk AJAX
            return response()->json([
                'success' => true,
                'campaign' => 'sukses'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
