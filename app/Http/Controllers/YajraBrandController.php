<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class YajraBrandController
{
    public function tampil_data()
    {
        $brands = Brand::where('User_id', Auth::user()->id)->with('User')
            ->orderBy('created_at', 'desc')
            ->select('brands.*');

        return DataTables::of($brands)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })
            ->addColumn('action', function ($row) {
                return '
                <button class="btn btn-sm btn-warning editBrandBtn" data-id="' . $row->id . '" data-name="' . $row->nama . '">Edit</button>
                <button class="btn btn-sm btn-danger deleteBrandBtn" data-id="' . $row->id . '">Hapus</button>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
