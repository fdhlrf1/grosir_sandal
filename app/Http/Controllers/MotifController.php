<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use App\Models\Kategori;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MotifController extends Controller
{
    //
    public function index(Request $request)
    {

        $search = $request->input('search');


        $id_toko = session('id_toko');
        $id_user = session('id_user');


        // $motifs = Motif::with('kategori')
        //     ->where('id_toko', $id_toko)
        //     ->when($search, function ($query, $search) {
        //         return $query->WhereHas('kategori', function ($query) use ($search) {
        //             $query->where('nama', 'like', "%{$search}%");
        //         })->orWhere('nama_motif', 'like', "%{$search}%");
        //     })->latest()->simplePaginate(5);

        // Query untuk $motifs
        $motifs = Motif::with('kategori')
            ->where('id_toko', $id_toko)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->whereHas('kategori', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%");
                    })
                        ->orWhere('nama_motif', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->simplePaginate(5);

        $kategoris = Kategori::where('id_toko', $id_toko)->latest()->get();

        return view('datautama.d_motif', [
            'title' => 'Data Motif',
            'kategoris' => $kategoris,
            'motifs' => $motifs
        ]);
    }

    public function create()
    {
        // // Ambil id_toko dari session
        // $id_toko = session('id_toko');

        // $kategoris = Kategori::where('id_toko', $id_toko)
        //     ->latest()
        //     ->get(); // Ubah paginate menjadi get() jika hanya ingin menampilkan semua data kategori

        // $motifs = Motif::all();
        // return view('datautama.crudmotif.create', [
        //     'title' => 'Tambah Motif',
        //     'kategoris' => $kategoris,
        //     'motifs' => $motifs,

        // ]);
    }

    public function getMotifByKategori($idKategori)
    {
        $motifs = Motif::where('id_kategori', $idKategori)->pluck('nama_motif', 'id_motif');

        return response()->json($motifs);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_motif' => 'required|string|max:200|regex:/^[\pL\pN\s.,\-!]+$/u',
            'id_kategori' => 'required|exists:tkategori,id_kategori',
        ]);

        $motif = Motif::create([
            'id_user' => session('id_user'),
            'id_toko' => session('id_toko'),
            'nama_motif' => $request->nama_motif,
            'id_kategori' => $request->id_kategori,
        ]);

        if ($motif) {
            return redirect()->route('motif.index')->with(['success' => 'Motif Berhasil Ditambahkan']);
        } else {
            return redirect()->route('motif.index')->with(['error' => 'Motif Gagal Ditambahkan']);
        }
    }

    public function edit(string $id)
    {
        // $motifs = Motif::findOrFail($id);

        // $id_toko = session('id_toko');

        // $kategoris = Kategori::where('id_toko', $id_toko)
        //     ->latest()
        //     ->get(); // Ubah paginate menjadi get() jika hanya ingin menampilkan semua Motif kategori

        // $title = 'Edit Motif'; // Menambahkan title

        // return view('Motifutama.crudmotif.edit', [
        //     'title' => $title,
        //     'motif' => $motifs,
        //     'kategoris' => $kategoris,
        // ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_motif' => 'required|string|max:200|regex:/^[\pL\pN\s.,\-!]+$/u',
            'id_kategori' => 'required|exists:tkategori,id_kategori',
        ]);

        $motif = Motif::findOrFail($id);

        $motif->nama_motif = $request->nama_motif;
        $motif->id_kategori = $request->id_kategori;
        $motif->save();

        if ($motif) {
            return redirect()->route('motif.index')->with(['success' => 'Motif Berhasil Diubah']);
        } else {
            return redirect()->route('motif.index')->with(['error' => 'Motif Gagal Diubah']);
        }
    }

    public function destroy($id): RedirectResponse
    {
        $motif = Motif::findOrFail($id);

        $motif->delete();

        if ($motif) {
            return redirect()->route('motif.index')->with(['success' => 'Motif Berhasil Dihapus']);
        } else {
            return redirect()->route('motif.index')->with(['error' => 'Motif Gagal Dihapus']);
        }
    }
}
