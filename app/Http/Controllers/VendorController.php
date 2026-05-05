<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    // Menampilkan halaman Vendor dan daftar menu
    public function index()
    {
        $vendor = Vendor::first(); 
        $menus = Menu::where('idvendor', $vendor->idvendor)->get();
        
        $pesananMasuk = DB::table('pesanans')
            ->join('detail_pesanans', 'pesanans.idpesanan', '=', 'detail_pesanans.idpesanan')
            ->join('menus', 'detail_pesanans.idmenu', '=', 'menus.idmenu')
            ->where('menus.idvendor', $vendor->idvendor)
            ->where('pesanans.status_bayar', 'Lunas')
            ->select('pesanans.idpesanan', 'pesanans.nama as nama_pembeli', 'pesanans.updated_at', 'menus.nama_menu', 'detail_pesanans.jumlah', 'detail_pesanans.subtotal')
            ->orderBy('pesanans.updated_at', 'desc')
            ->get();
        
        return view('vendor.index', compact('vendor', 'menus', 'pesananMasuk'));
    }

    // Fungsi untuk menyimpan menu baru beserta gambar
    public function storeMenu(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $vendor = Vendor::first();

        // Proses unggah gambar
        $imagePath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Simpan ke storage/app/public/menus
            $imagePath = $file->storeAs('menus', $fileName, 'public');
        }

        // Simpan ke database
        Menu::create([
            'idvendor' => $vendor->idvendor,
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'path_gambar' => $imagePath,
        ]);

        return redirect()->route('vendor.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Menampilkan Halaman Edit Menu
    public function edit($id)
    {
        $menu = Menu::where('idmenu', $id)->firstOrFail();
        return view('vendor.edit', compact('menu'));
    }

    // Memproses Perubahan Data Menu
    public function update(Request $request, $id)
    {
        $menu = Menu::where('idmenu', $id)->firstOrFail();
        
        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $request->harga;

        // Cek jika vendor mengupload foto baru
        if ($request->hasFile('foto_menu')) {
            $file = $request->file('foto_menu');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            // Simpan ke folder public/menu_images (sesuaikan dengan folder upload Anda)
            $file->move(public_path('menu_images'), $nama_file); 
            $menu->path_gambar = $nama_file;
        }

        $menu->save();

        return redirect()->route('vendor.index')->with('success', 'Menu berhasil diupdate!');
    }

    // Menghapus Menu
    public function destroy($id)
    {
        $menu = Menu::where('idmenu', $id)->firstOrFail();
        $menu->delete();

        return redirect()->route('vendor.index')->with('success', 'Menu berhasil dihapus!');
    }
public function cekPesanan($idpesanan) {
      $detail = \Illuminate\Support\Facades\DB::table('pesanan')
          ->join('detail_pesanan', 'pesanan.idpesanan', '=', 'detail_pesanan.idpesanan')
          ->join('menus', 'detail_pesanan.idmenu', '=', 'menus.idmenu')
          ->where('pesanan.idpesanan', $idpesanan)
          ->select('menus.nama_menu', 'pesanan.status_bayar')
          ->get();
          
      return response()->json($detail);
  }
}