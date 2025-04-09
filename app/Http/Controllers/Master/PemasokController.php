<?php

namespace App\Http\Controllers\Master;

use App\Models\Pemasok;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PemasokController extends Controller
{
    //
    public function index(Request $request)
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_toko dari session
        $id_toko = session('id_toko');
        $id_user = session('id_user');

        $pemasoks = Pemasok::where('id_toko', $id_toko)
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%");
            })
            ->latest()
            ->simplePaginate(5);

        // Menyesuaikan dengan kolom primary key
        return view('datautama.d_pemasok', [
            'title' => 'Data Pemasok',
            'pemasoks' => $pemasoks,
            'search' => $search,
        ]);
    }


    public function create()
    {
        // $pemasoks = Pemasok::all();
        // return view('datautama.crudpemasok.create', [
        //     'title' => 'Tambah Pemasok',
        //     'pemasoks' => $pemasoks,

        // ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'alamat' => 'required|string|max:200|regex:/^[\pL\s\-\d]+$/u',
            'telepon' => 'required|string|max:50|regex:/^[0-9\s+]*$/',
        ]);


        Pemasok::create([
            'id_user' => session('id_user'),
            'id_toko' => session('id_toko'),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,

        ]);

        return redirect()->route('pemasok.index')->with(['success' => 'Pemasok Berhasil DiTambahkan']);
    }

    public function edit(string $id)
    {
        // $pemasoks = Pemasok::findOrFail($id);

        // $title = 'Edit Pemasok';

        // return view('Pemasokutama.crudpemasok.modal-edit', [
        //     'title' => $title,
        //     'pemasok' => $pemasoks
        // ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'alamat' => 'required|string|max:200|regex:/^[\pL\s\-\d]+$/u',
            'telepon' => 'required|string|max:50|regex:/^[0-9\s+]*$/',

        ]);

        $pemasok = Pemasok::findOrFail($id);

        $pemasok->nama = $request->nama;
        $pemasok->alamat = $request->alamat;
        $pemasok->telepon = $request->telepon;
        $pemasok->save();

        return redirect()->route('pemasok.index')->with(['success' => 'Pemasok Berhasil Diubah']);
    }

    public function destroy($id): RedirectResponse
    {
        $pemasok = Pemasok::findOrFail($id);

        $pemasok->delete();

        return redirect()->route('pemasok.index')->with(['success' => 'Pemasok Berhasil Dihapus']);
    }
}
