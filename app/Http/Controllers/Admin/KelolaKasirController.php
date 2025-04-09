<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class KelolaKasirController extends Controller
{
    public function index(Request $request)
    {
        $id_toko = session('id_toko');
        $id_user = session('id_user');

        $search = $request->input('search');

        // $kasirs = User::with('role')
        //     ->where('role_id', 2)
        //     ->where('toko_id', $id_toko)
        //     ->when($search, function ($query, $search) {
        //         return $query->WhereHas('role', function ($query) use ($search) {
        //             $query->where('nama_role', 'like', "%{$search}%");
        //         })
        //             ->orWhere('name', 'like', "%{$search}%")
        //             ->orWhere('username', 'like', "%{$search}%")
        //             ->orWhere('nama_toko', 'like', "%{$search}%");
        //     })->latest()->simplePaginate(5);

        $kasirs = User::with('role')
            ->where('role_id', 2)
            ->where('toko_id', $id_toko)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->whereHas('role', function ($query) use ($search) {
                        $query->where('nama_role', 'like', "%{$search}%");
                    })
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('nama_toko', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->simplePaginate(5);




        // $kategoris = Kategori::where('id_toko', $id_toko)->latest()->get();

        return view('kelola.kelolakasir', [
            'title' => 'Kelola Kasir',
            'kasirs' => $kasirs,
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $id_toko = session('id_toko');

        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-\d]+$/u', // Mengizinkan huruf, angka, spasi, dan tanda hubung
            'username' => 'required|string|max:200|alpha_dash', // Hanya huruf, angka, tanda hubung, dan underscore
            'nama_toko' => 'required|string|max:50|regex:/^[\pL\s\-\d]+$/u', // Mengizinkan huruf, angka, spasi, dan tanda hubung
            'password' => 'required|string|min:6|max:50|regex:/^[\w@#\-\$\!\%\*]+$/', // Minimum 8 karakter, huruf, angka, atau karakter khusus seperti @, #, -, $, !, %, *
        ]);

        // dd($request->all());

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'nama_toko' => $request->nama_toko,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'toko_id' => $id_toko,
        ]);

        return redirect()->route('kelolakasir.index')->with(['success' => 'Kasir Berhasil DiTambahkan']);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|regex:/^[\pL\s\-\d]+$/u', // Mengizinkan huruf, angka, spasi, dan tanda hubung
            'username' => 'required|string|max:200|alpha_dash', // Hanya huruf, angka, tanda hubung, dan underscore
            'nama_toko' => 'required|string|max:50|regex:/^[\pL\s\-\d]+$/u', // Mengizinkan huruf, angka, spasi, dan tanda hubung
            'password' => 'nullable|string|min:6|max:50|regex:/^[\w@#\-\$\!\%\*]+$/', // Minimum 8 karakter, huruf, angka, atau karakter khusus seperti @, #, -, $, !, %, *
        ]);

        // dd($request->all());

        $user = User::findOrFail($id);

        $user->name = $request->nama;
        $user->username = $request->username;
        $user->nama_toko = $request->nama_toko;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password')); // Enkripsi password
        }
        // $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with(['success' => 'Kasir Berhasil Diubah']);
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('kelolakasir.index')->with(['success' => 'Kasir Berhasil Dihapus']);
    }
}
