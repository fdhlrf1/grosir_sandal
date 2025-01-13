<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class PelunasanController extends Controller
{
    // public function index()
    // {
    //     $id_user = session('id_user');

    //     $pelunasanPenjualan = Penjualan::with('konsumen')
    //         ->where('status', 'Belum Lunas')
    //         ->where('id_user', $id_user)
    //         ->get();

    //     foreach ($pelunasanPenjualan as $item1) {
    //         $item1->tanggal = Carbon::parse($item1->tanggal_pembayaran)->format('Y-m-d'); // Format Tanggal
    //         $item1->waktu = Carbon::parse($item1->tanggal_pembayaran)->format('H:i:s'); // Format Waktu
    //     }

    //     // $pelunasanPembelian = DB::table('tpembelian')
    //     //     ->where('status', 'Belum Lunas')
    //     //     ->where('id_user', $id_user)
    //     //     ->get();

    //     return view('transaksi.pelunasan', [
    //         'pelunasanPenjualan' => $pelunasanPenjualan,
    //         'title' => 'Pelunasan',
    //     ]);
    // }

    public function update(Request $request, $id): RedirectResponse
    {
        // try {
        $validated = $request->validate([
            'jumlah_pelunasan' => 'required', // Hanya menerima angka integer positif
            'tanggal_lunas.*' => 'required|date_format:Y-m-d',  // Validasi datetime dengan format Y-m-d H:i:s
            'sisa' => 'required',
        ]);

        // dd($request->all());


        //     dd($validated);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e->validator->errors()->all()); // Menampilkan semua kesalahan validasi
        // }

        // session(['jumlah_pelunasan' => $request->jumlah_pelunasan]);
        // session(['tanggal_lunas' => $request->tanggal_lunas]);

        $jumlah_pelunasanS = str_replace('.', '', str_replace('Rp. ', '', $request->jumlah_pelunasan));
        $sisaS = str_replace('.', '', str_replace('Rp. ', '', $request->sisa));

        $jumlah_pelunasan = intval($jumlah_pelunasanS);
        $sisa = intval($sisaS);

        $tanggal_lunas = Carbon::createFromFormat('Y-m-d', $request->input('tanggal_lunas')[0])->format('Y-m-d');


        // dd([
        //     'jumlahpelunasan' => $jumlah_pelunasan,
        //     'tanggal_lunas' => $tanggal_lunas,
        //     'sisa' => $sisa,
        // ]);

        if ($jumlah_pelunasan < $sisa) {
            return redirect()->back()->with('errorpelunasan', 'Jumlah pelunasan tidak mencukupi. Silakan masukkan jumlah yang sesuai dengan sisa pembayaran.');
        } else {
            $pelunasan = Penjualan::findOrFail($id);

            $sisa = $pelunasan->sisa;

            if ($jumlah_pelunasan >= $sisa) {
                $status = 'Lunas';
                $sisa = 0;
                $bayar = $pelunasan->bayar += $jumlah_pelunasan;
                $kembalian = $bayar - $pelunasan->total;
            }

            // dd([
            //     'status' => $status,
            //     'bayar' => $bayar,
            //     'sisa' => $sisa,
            //     'kembalian' => $kembalian,
            // ]);
            // dd([
            //     'Bayar' => $pelunasan->bayar = $bayar,
            //     'Kembalian' => $pelunasan->kembalian = $kembalian,
            //     'status' => $pelunasan->status = $status,
            //     'sisa' => $pelunasan->sisa = $sisa,
            //     'tanggaljatuhtempo' => ($sisa > 0) ? $pelunasan->tanggal_jatuh_tempo : null, // Set null jika lunas
            //     'tanggallunas' =>  $pelunasan->tanggal_lunas = $tanggal_lunas,
            //     'jumlahpelunasan' =>  $pelunasan->jumlah_pelunasan = $jumlah_pelunasan,

            // ]);
            $pelunasan->bayar = $bayar;
            $pelunasan->kembalian = $kembalian;
            $pelunasan->status = $status;
            $pelunasan->sisa = $sisa;
            $pelunasan->tanggal_jatuh_tempo = ($sisa > 0) ? $pelunasan->tanggal_jatuh_tempo : null; // Set null jika lunas
            $pelunasan->tanggal_lunas = $tanggal_lunas;
            $pelunasan->jumlah_pelunasan = $jumlah_pelunasan;
            $pelunasan->save();

            if ($pelunasan) {
                return redirect()->route('laporanpenjualan.index')->with(['success' => 'Pelunasan Berhasil']);
            } else {
                return redirect()->route('laporanpenjualan.index')->with(['error' => 'Pelunasan Gagal']);
            }
        }
    }
}