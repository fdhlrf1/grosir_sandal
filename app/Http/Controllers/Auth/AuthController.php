<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string|',
            'password' => 'required|string',
        ]);

        // Cek kredensial pengguna
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            $user = Auth::user();
            $role = Auth::user()->role_id;

            $toko = $user->toko;

            $welcomeMessage = [
                'name' => $user->name,
                'role' => $role == 1 ? 'Admin' : ($role == 2 ? 'Kasir' : 'Tidak Dikenali'),
            ];
            session()->flash('login_message', $welcomeMessage);

            // Simpan id_toko ke dalam session
            $request->session()->put('id_user', Auth::id());
            $request->session()->put('id_user_penjualan', Auth::id());
            $request->session()->put('id_user_pembelian', Auth::id());

            $request->session()->put('id_toko', $toko->id);
            $request->session()->put('id_toko_penjualan', $toko->id);
            $request->session()->put('id_toko_pembelian', $toko->id);
            // dd($toko->id);
            $request->session()->put('nama_toko', $toko->nama_toko); // Simpan nama toko

            if ($role == 1) {
                // Redirect untuk admin
                return redirect()->intended(route('beranda'));
            } elseif ($role == 2) {
                // Redirect untuk kasir
                return redirect()->intended(route('beranda'));
            } else {
                // Redirect jika role tidak diketahui
                Auth::logout(); // Log out user
                return redirect()->back()->withErrors([
                    'username' => 'Role tidak dikenali.',
                ]);
            }
        }

        // Jika kredensial salah, kembalikan ke form login dengan pesan error
        return redirect()->back()->withErrors([
            'login_error' => 'Username atau Password Salah!',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Menghapus sesi dan redirect ke halaman login
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
