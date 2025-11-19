<?php

namespace App\Http\Controllers;

use App\Models\Perbandingan;
use Illuminate\Http\Request;
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
                                <a href="' . url('/perbandingan/' . $row->id . '/edit') . '" 
                                class="btn btn-sm btn-warning">
                                Edit
                                </a>
                            </div>
                        ';
                })


                ->rawColumns(['action', 'brand', 'tanggal_awal', 'tanggal_akhir'])
                ->make(true);
        }
    }
}
