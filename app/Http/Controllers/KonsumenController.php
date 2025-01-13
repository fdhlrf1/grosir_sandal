<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class KonsumenController extends Controller
{
    //
    public function index(Request $request)
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_toko dari session
        $id_toko = session('id_toko');
        $id_user = session('id_user');


        $konsumens = Konsumen::where('id_toko', $id_toko)
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%");
            })
            ->latest()
            ->simplePaginate(5);

        // Menyesuaikan dengan kolom primary key
        return view('datautama.d_konsumen', [
            'title' => 'Data Konsumen',
            'konsumens' => $konsumens,
            'search' => $search,
        ]);
    }

    public function create()
    {
        // $konsumens = Konsumen::all();
        // return view('datautama.crudkonsumen.create', [
        //     'title' => 'Tambah Konsumen',
        //     'konsumens' => $konsumens,

        // ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'alamat' => 'required|string|max:200|regex:/^[\pL\s\-\d]+$/u',
            'telepon' => 'required|string|max:50|regex:/^[0-9\s+]*$/',
        ]);

        $konsumen = Konsumen::create([
            'id_user' => session('id_user'),
            'id_toko' => session('id_toko'),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,

        ]);

        if ($konsumen) {
            return redirect()->route('konsumen.index')->with(['success' => 'Konsumen Berhasil Ditambahkan']);
        } else {
            return redirect()->route('konsumen.index')->with(['error' => 'Konsumen Gagal Ditambahkan']);
        }
    }

    public function edit(string $id)
    {
        // $konsumens = Konsumen::findOrFail($id);

        // $title = 'Edit Konsumen'; // Menambahkan title

        // return view('datautama.crudkonsumen.edit', [
        //     'title' => $title,
        //     'konsumen' => $konsumens
        // ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'alamat' => 'required|string|max:200|regex:/^[\pL\s\-\d]+$/u',
            'telepon' => 'required|string|max:50|regex:/^[0-9\s+]*$/',
        ]);

        $konsumen = Konsumen::findOrFail($id);

        $konsumen->nama = $request->nama;
        $konsumen->alamat = $request->alamat;
        $konsumen->telepon = $request->telepon;
        $konsumen->save();

        if ($konsumen) {
            return redirect()->route('konsumen.index')->with(['success' => 'Konsumen Berhasil Diubah']);
        } else {
            return redirect()->route('konsumen.index')->with(['error' => 'Konsumen Gagal Diubah']);
        }
    }

    public function destroy($id): RedirectResponse
    {
        $konsumen = Konsumen::findOrFail($id);

        $konsumen->delete();

        if ($konsumen) {
            return redirect()->route('konsumen.index')->with(['success' => 'Konsumen Berhasil Dihapus']);
        } else {
            return redirect()->route('konsumen.index')->with(['error' => 'Konsumen Gagal Dihapus']);
        }
    }
}
