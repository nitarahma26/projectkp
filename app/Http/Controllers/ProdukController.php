<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index()
    {
        // Mengambil data produk dengan join ke tabel kategori
        $produk = DB::table('produks')
            ->join('kategoris', 'produks.kategori_id', '=', 'kategoris.id')
            ->select('produks.*', 'kategoris.nama_kategori')
            ->get();

        return view('DataMaster.produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = DB::table('kategoris')->get();
        return view('DataMaster.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'total_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $data = [
                'kategori_id' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'total_jual' => $request->total_jual,
                'stok' => $request->stok,
                'created_at' => now(),
                'updated_at' => now()
            ];

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
                $gambar->move(public_path('images'), $nama_gambar);
                $data['gambar'] = $nama_gambar;
            }

            DB::table('produks')->insert($data);

            return redirect()->route('DataMaster.produk.index')
                ->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $produk = DB::table('produks')->where('id', $id)->first();
            if (!$produk) {
                return redirect()->route('DataMaster.produk.index')
                    ->with('error', 'Produk tidak ditemukan');
            }

            $kategori = DB::table('kategoris')->get();
            return view('DataMaster.produk.edit', compact('produk', 'kategori'));
        } catch (\Exception $e) {
            return redirect()->route('DataMaster.produk.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'total_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $data = [
                'kategori_id' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'total_jual' => $request->total_jual,
                'stok' => $request->stok,
                'updated_at' => now()
            ];

            if ($request->hasFile('gambar')) {
                $produk = DB::table('produks')->where('id', $id)->first();
                if ($produk && $produk->gambar) {
                    $old_image_path = public_path('images/' . $produk->gambar);
                    if (File::exists($old_image_path)) {
                        File::delete($old_image_path);
                    }
                }

                $gambar = $request->file('gambar');
                $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
                $gambar->move(public_path('images'), $nama_gambar);
                $data['gambar'] = $nama_gambar;
            }

            DB::table('produks')->where('id', $id)->update($data);

            return redirect()->route('DataMaster.produk.index')
                ->with('success', 'Produk berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function tambahStok()
    {
        // Mengambil data produk dengan join ke tabel kategori
        $produk = DB::table('produks')
            ->join('kategoris', 'produks.kategori_id', '=', 'kategoris.id')
            ->select('produks.*', 'kategoris.nama_kategori')
            ->get();

        return view('DataMaster.TambahStokProduk.index', compact('produk'));
    }

    public function updateStok(Request $request, $id)
    {
        try {
            $produk = DB::table('produks')->where('id', $id)->first();

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ]);
            }

            $stok_sebelumnya = $produk->stok;
            $stok_baru = $stok_sebelumnya + $request->tambah_stok;

            DB::table('produks')
                ->where('id', $id)
                ->update([
                    'stok' => $stok_baru,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil ditambahkan',
                'stok_sebelumnya' => $stok_sebelumnya,
                'stok_baru' => $stok_baru
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }



    public function destroy($id)
    {
        try {
            $produk = DB::table('produks')->where('id', $id)->first();
            if (!$produk) {
                return redirect()->route('DataMaster.produk.index')
                    ->with('error', 'Produk tidak ditemukan');
            }

            if ($produk->gambar) {
                $image_path = public_path('images/' . $produk->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            DB::table('produks')->where('id', $id)->delete();
            return redirect()->route('DataMaster.produk.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('DataMaster.produk.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
