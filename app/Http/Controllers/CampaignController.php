<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CampaignMetric;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        return view('admin.campaign.index', [
            'title' => 'Campaign',
            'campaigns' => CampaignMetric::where('user_id', Auth::user()->id)->with('User', 'Brand')->orderBy('created_at', 'desc')->get()
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
        if ($request->platform == 'tiktok') {
            $request->validate([
                // 'cost'                  => 'required',
                'cpm'                   => 'required',
                'impression'            => 'required',
                'klik'                  => 'required',
                'cpc'                   => 'required',
                'page_view'             => 'required',
                'cpv'                   => 'required',
                'initiate'              => 'required',
                'cost_per_initiate'     => 'required',
                'result'                => 'required',
                'cpr'                   => 'required',
            ]);
        } else {
            $request->validate([
                // 'cost'                  => 'required',
                'order'                 => 'required',
                'cost_per_order'        => 'required',
                'gross_revenue'         => 'required',
                'roi'                   => 'required',
            ]);
        }

        try {
            if ($request->platform === 'tiktok') {
                $cost = $request->cost_tiktok ?? $request->cost_gmvmax ?? 0;
            } elseif ($request->platform === 'gmvmax') {
                $cost = $request->cost_gmvmax ?? $request->cost_tiktok ?? 0;
            } else {
                $cost = 0;
            }


            $createCampaign = CampaignMetric::create([
                'user_id'               => Auth::id(),
                'tanggal'               => now(),
                'brand_id'              => $request->brand_id,
                'platform'              => $request->platform,
                'jenis_campaign'        => $request->jenis_campaign,

                'cost'                  => $cost,
                'cpm'                   => $request->cpm ?? 0,
                'impression'            => $request->impression ?? 0,
                'klik'                  => $request->klik ?? 0,
                'cpc'                   => $request->cpc ?? 0,
                'page_view'             => $request->page_view ?? 0,
                'cpv'                   => $request->cpv ?? 0,
                'initiate'              => $request->initiate ?? 0,
                'cost_per_initiate'     => $request->cost_per_initiate ?? 0,
                'result'                => $request->result ?? 0,
                'cpr'                   => $request->cpr ?? 0,
                'order'                 => $request->order ?? 0,
                'cost_per_order'        => $request->cost_per_order ?? 0,
                'gross_revenue'         => $request->gross_revenue ?? 0,
                'roi'                   => $request->roi ?? 0,
            ]);

            // Kembalikan response JSON untuk AJAX
            return response()->json([
                'success' => true,
                'campaign' => $createCampaign
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $campaign = CampaignMetric::findOrFail($id);
        $brands = Brand::all();
        $title = 'Edit Campaign';

        // kirim data ke view yang sama (create.blade.php)
        return view('admin.campaign.create', compact('campaign', 'brands', 'title'));
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'brand_id'                 => 'required',
            'platform'                 => 'required',
        ]);

        $campaign = CampaignMetric::findOrFail($id);

        try {
            if ($request->platform === 'tiktok') {
                $cost = $request->cost_tiktok ?? $request->cost_gmvmax ?? 0;
            } elseif ($request->platform === 'gmvmax') {
                $cost = $request->cost_gmvmax ?? $request->cost_tiktok ?? 0;
            } else {
                $cost = 0;
            }

            $createCampaign = $campaign->update([
                'user_id'               => Auth::id(),
                'tanggal'               => now(),
                'brand_id'              => $request->brand_id,
                'platform'              => $request->platform,
                'jenis_campaign'        => $request->jenis_campaign,

                'cost'                  => $cost,
                'cpm'                   => $request->cpm ?? 0,
                'impression'            => $request->impression ?? 0,
                'klik'                  => $request->klik ?? 0,
                'cpc'                   => $request->cpc ?? 0,
                'page_view'             => $request->page_view ?? 0,
                'cpv'                   => $request->cpv ?? 0,
                'initiate'              => $request->initiate ?? 0,
                'cost_per_initiate'     => $request->cost_per_initiate ?? 0,
                'result'                => $request->result ?? 0,
                'cpr'                   => $request->cpr ?? 0,
                'order'                 => $request->order ?? 0,
                'cost_per_order'        => $request->cost_per_order ?? 0,
                'gross_revenue'         => $request->gross_revenue ?? 0,
                'roi'                   => $request->roi ?? 0,
            ]);

            // Kembalikan response JSON untuk AJAX
            return response()->json([
                'success' => true,
                'campaign' => $createCampaign
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }




    public function hapus($id)
    {
        try {
            $campaignMetrix = CampaignMetric::findOrFail($id);

            // Pastikan user punya hak akses
            if ($campaignMetrix->user_id != Auth::user()->id) {
                return response()->json(['success' => false, 'message' => 'Tidak punya akses.']);
            }

            $campaignMetrix->delete();

            return response()->json([
                'success' => true,
                'message' => 'Campaign berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
