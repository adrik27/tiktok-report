<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brands.index', [
            'title' => 'Brands',
        ]);
    }

    public function create(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            // Simpan data
            $brand = Brand::create([
                'nama' => $request->nama,
                'User_id' => Auth::user()->id,
            ]);

            // Kembalikan response JSON untuk AJAX
            return response()->json([
                'success' => true,
                'brand' => $brand
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Update brand
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            $brand = Brand::findOrFail($id);

            // Pastikan user punya hak akses
            if ($brand->User_id != Auth::user()->id) {
                return response()->json(['success' => false, 'message' => 'Tidak punya akses.']);
            }

            $brand->update([
                'name' => $request->nama
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil diupdate.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Hapus brand
    public function hapus($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Pastikan user punya hak akses
            if ($brand->User_id != Auth::user()->id) {
                return response()->json(['success' => false, 'message' => 'Tidak punya akses.']);
            }

            $brand->delete();

            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
