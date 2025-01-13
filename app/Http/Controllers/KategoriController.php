<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    //
    public function index(Request $request)
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_toko dari session
        $id_toko = session('id_toko');
        $id_user = session('id_user');


        // Ambil data kategori berdasarkan user yang sedang login
        $kategoris = Kategori::where('id_toko', $id_toko) // Tambahkan filter berdasarkan id_toko
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->latest()
            ->simplePaginate(5);


        return view('datautama.d_kategori', [
            'title' => 'Data Kategori',
            'kategoris' => $kategoris
        ]);
    }

    public function create()
    {
        // $kategoris = Kategori::all();
        // return view('datautama.crudkategori.create', [
        //     'title' => 'Tambah Kategori',
        //     'kategoris' => $kategoris,

        // ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'deskripsi' => 'required|string|max:200|regex:/^[\pL\pN\s.,\-!]+$/u',

        ]);

        $kategori = Kategori::create([
            'id_user' => session('id_user'),
            'id_toko' => session('id_toko'),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success' => 'Kategori Berhasil Ditambahkan']);
        } else {
            return redirect()->route('kategori.index')->with(['error' => 'Kategori Gagal Ditambahkan']);
        }
    }

    public function edit(string $id)
    {
        // $kategoris = Kategori::findOrFail($id);

        // $title = 'Edit Kategori';

        // return view('datautama.crudkategori.edit', [
        //     'title' => $title,
        //     'kategori' => $kategoris
        // ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'deskripsi' => 'required|string|max:200|regex:/^[\pL\pN\s.,\-!]+$/u',
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();

        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success' => 'Kategori Berhasil Diubah']);
        } else {
            return redirect()->route('kategori.index')->with(['error' => 'Kategori Gagal Diubah']);
        }
    }

    public function destroy($id): RedirectResponse
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success' => 'Kategori Berhasil Dihapus']);
        } else {
            return redirect()->route('kategori.index')->with(['error' => 'Kategori Gagal Dihapus']);
        }
    }
}
