<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|alpha_num|max:255|unique:users',
            'nama_toko' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Cek apakah nama_toko sudah ada
        $toko = Toko::firstOrCreate(
            ['nama_toko' => $request->nama_toko], // Cek berdasarkan nama_toko
            [] // Jika belum ada, tidak ada data tambahan yang perlu dimasukkan
        );

        // dd(session('nama_toko'));
        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nama_toko' => $request->nama_toko,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'toko_id' => $toko->id,
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        $data = session()->flash('login_message', [
            'name' => $user->name,
            'role' => 'Kasir' // Ganti sesuai dengan role yang tepat jika perlu
        ]);

        // Simpan id_user ke dalam session
        session()->put('nama_toko', $request->nama_toko);
        session()->put('id_toko', $toko->id);
        $request->session()->put('id_user', $user->id);

        // Redirect ke halaman beranda atau tujuan lain
        return redirect()->intended('/beranda');
    }
}
