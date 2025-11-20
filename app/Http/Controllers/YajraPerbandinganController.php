<?php

namespace App\Http\Controllers;

use App\Models\Perbandingan;
use Illuminate\Http\Request;
use App\Models\RiwayatPerbandingan;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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
                    return '
                        <div class="d-flex justify-content-center gap-2">
                                <a href="' . url('/perbandingan/' . $row->id . '/detail') . '" 
                                class="btn btn-sm btn-info">
                                Detail
                                </a>
                                <button class="btn btn-sm btn-danger deletePerbandinganBtn" 
                                data-id="' . $row->id . '">
                                Hapus
                                </button>
                            </div>
                        ';
                })


                ->rawColumns(['action', 'brand', 'tanggal_awal', 'tanggal_akhir', 'files'])
                ->make(true);
        }
    }

    public function tampil_data_detail(Request $post)
    {
        if ($post->ajax()) {
            $id = $post->perbandingan_id;

            $riwayat_perbandingan = RiwayatPerbandingan::where('perbandingan_id', $id)
                ->with('Perbandingan')
                ->get();

            return DataTables::of($riwayat_perbandingan)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
