<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_toko dari session
        $id_user = session('id_user');
        $id_toko = session('id_toko');


        $satuans = Satuan::where('id_toko', $id_toko)
            ->when($search, function ($query, $search) {
                return $query->where('nama_satuan', 'like', "%{$search}%")
                    ->orWhere('konversi', 'like', "%{$search}%");
            })
            ->latest()
            ->simplePaginate(5);


        return view('datautama.d_satuan', [
            'title' => 'Data Satuan',
            'satuans' => $satuans
        ]);
    }

    public function create()
    {
        // $satuans = Satuan::all();
        // return view('datautama.crudsatuan.create', [
        //     'title' => 'Tambah Satuan',
        //     'satuans' => $satuans,

        // ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'konversi' => 'required|numeric|min:0',
        ]);


        $satuan =  Satuan::create([
            'id_user' => session('id_user'),
            'id_toko' => session('id_toko'),
            'nama_satuan' => $request->nama_satuan,
            'konversi' => $request->konversi,
        ]);

        if ($satuan) {
            return redirect()->route('satuan.index')->with(['success' => 'Satuan Berhasil Ditambahkan']);
        } else {
            return redirect()->route('satuan.index')->with(['error' => 'Satuan Gagal Ditambahkan']);
        }
    }

    public function edit(string $id)
    {
        // $satuans = Satuan::findOrFail($id);

        // $title = 'Edit Pemasok'; // Menambahkan title

        // return view('datautama.crudsatuan.edit', [
        //     'title' => $title,
        //     'satuan' => $satuans
        // ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'konversi' => 'required|numeric|min:0',
        ]);

        $satuan = Satuan::findOrFail($id);

        $satuan = $request->nama_satuan;
        $satuan = $request->konversi;
        $satuan->save();

        if ($satuan) {
            return redirect()->route('satuan.index')->with(['success' => 'Satuan Berhasil Diubah']);
        } else {
            return redirect()->route('satuan.index')->with(['error' => 'Satuan Gagal Diubah']);
        }
    }

    public function destroy($id): RedirectResponse
    {
        $satuan = Satuan::findOrFail($id);

        $satuan->delete();

        if ($satuan) {
            return redirect()->route('satuan.index')->with(['success' => 'Satuan Berhasil Dihapus']);
        } else {
            return redirect()->route('satuan.index')->with(['error' => 'Satuan Gagal Dihapus']);
        }
    }
}
