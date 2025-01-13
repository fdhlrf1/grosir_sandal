<?php

namespace App\Http\Controllers;

use App\Models\Ukuran;
use App\Models\Kategori;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UkuranController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');

        $id_toko = session('id_toko');
        $id_user = session('id_user');

        // dd([
        //     'iduser' => $id_user,
        //     'idtoko' => $id_toko,
        // ]);

        // $ukurans = Ukuran::with('kategori')
        //     ->where('id_toko', $id_toko)
        //     ->when($search, function ($query, $search) {
        //         return $query->WhereHas('kategori', function ($query) use ($search) {
        //             $query->where('nama', 'like', "%{$search}%");
        //         })->orWhere('ukuran', 'like', "%{$search}%");
        //     })
        //     ->latest()
        //     ->simplePaginate(5);

        // Query untuk $ukurans
        $ukurans = Ukuran::with('kategori')
            ->where('id_toko', $id_toko)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->whereHas('kategori', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%");
                    })
                        ->orWhere('ukuran', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->simplePaginate(5);

        $kategoris = Kategori::where('id_toko', $id_toko)
            ->latest()
            ->get(); // Ubah paginate menjadi get() jika hanya ingin menampilkan semua data kategori

        return view('datautama.d_ukuran', [
            'title' => 'Data Warna',
            'kategoris' => $kategoris,
            'ukurans' => $ukurans
        ]);
    }

    public function create()
    {
        // // Ambil id_toko dari session
        // $id_toko = session('id_toko');

        // $kategoris = Kategori::where('id_toko', $id_toko)
        //     ->latest()
        //     ->get(); // Ubah paginate menjadi get() jika hanya ingin menampilkan semua data kategori

        // $ukurans = Ukuran::all();
        // return view('datautama.crudukuran.create', [
        //     'title' => 'Tambah Ukuran',
        //     'kategoris' => $kategoris,
        //     'ukurans' => $ukurans,

        // ]);
    }

    public function getUkuranByKategori($idKategori)
    {
        // Ambil ukuran berdasarkan kategori
        $ukurans = Ukuran::where('id_kategori', $idKategori)->pluck('ukuran');

        // Kembalikan dalam format JSON
        return response()->json($ukurans);
    }


    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'ukuran' => 'required|string|max:255',
            'id_kategori' => 'required|exists:tkategori,id_kategori', // Pastikan kategori ada
        ]);

        $ukuran = Ukuran::create([
            'id_user' => session('id_user'),
            'id_toko' => session('id_toko'),
            'id_kategori' => $request->id_kategori,
            'ukuran' => $request->ukuran,
        ]);

        if ($ukuran) {
            return redirect()->route('ukuran.index')->with(['success' => 'Ukuran Berhasil Ditambahkan']);
        } else {
            return redirect()->route('ukuran.index')->with(['error' => 'Ukuran Gagal Ditambahkan']);
        }
    }

    public function edit(string $id)
    {
        // $ukurans = Ukuran::findOrFail($id);

        // $id_toko = session('id_toko');

        // $kategoris = Kategori::where('id_toko', $id_toko)
        //     ->latest()
        //     ->get(); // Ubah paginate menjadi get() jika hanya ingin menampilkan semua Ukuran kategori

        // $title = 'Edit Ukuran'; // Menambahkan title

        // return view('Ukuranutama.crudukuran.edit', [
        //     'title' => $title,
        //     'ukuran' => $ukurans,
        //     'kategoris' => $kategoris,
        // ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'ukuran' => 'required|string|max:255',
            'id_kategori' => 'required|exists:tkategori,id_kategori',
        ]);

        $ukuran = Ukuran::findOrFail($id);

        $ukuran->id_kategori = $request->id_kategori;
        $ukuran->ukuran = $request->ukuran;
        $ukuran->save();

        if ($ukuran) {
            return redirect()->route('ukuran.index')->with(['success' => 'Ukuran Berhasil Diubah']);
        } else {
            return redirect()->route('ukuran.index')->with(['error' => 'Ukuran Gagal Diubah']);
        }
    }

    public function destroy($id): RedirectResponse
    {
        $ukuran = Ukuran::findOrFail($id);

        $ukuran->delete();

        if ($ukuran) {
            return redirect()->route('ukuran.index')->with(['success' => 'Ukuran Berhasil Dihapus']);
        } else {
            return redirect()->route('ukuran.index')->with(['error' => 'Ukuran Gagal Dihapus']);
        }
    }
}
