<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class RentangWaktuPelunasanTest extends TestCase
{
    /** @test */
    public function testRentangWaktuPelunasan()
    {
        // Set tanggal yang akan diuji
        $tanggalPembayaran = Carbon::parse('2024-10-23')->startOfDay();
        $tanggalJatuhTempo = Carbon::parse('2024-10-30')->startOfDay();

        // Hitung selisih hari
        $selisihHari = $tanggalPembayaran->diffInDays($tanggalJatuhTempo, false);
        if ($tanggalPembayaran->greaterThan($tanggalJatuhTempo)) {
            $keterangan = 'Terlambat ' . abs($selisihHari) . ' hari';
        } elseif ($tanggalPembayaran->equalTo($tanggalJatuhTempo)) {
            $keterangan = 'Pembayaran tepat di hari jatuh tempo';
        } else {
            $keterangan = $selisihHari . ' hari tersisa';
        }

        // Asserts
        $this->assertEquals('7 hari tersisa', $keterangan); // Pada tanggal 23, seharusnya 7 hari tersisa

        // Uji dengan mengubah tanggal pembayaran
        $tanggalPembayaran = Carbon::parse('2024-10-24')->startOfDay();
        $selisihHari = $tanggalPembayaran->diffInDays($tanggalJatuhTempo, false);
        if ($tanggalPembayaran->greaterThan($tanggalJatuhTempo)) {
            $keterangan = 'Terlambat ' . abs($selisihHari) . ' hari';
        } elseif ($tanggalPembayaran->equalTo($tanggalJatuhTempo)) {
            $keterangan = 'Pembayaran tepat di hari jatuh tempo';
        } else {
            $keterangan = $selisihHari . ' hari tersisa';
        }

        // Assert untuk tanggal yang diubah
        $this->assertEquals('6 hari tersisa', $keterangan); // Pada tanggal 24, seharusnya 6 hari tersisa

        // Uji dengan tanggal pembayaran lebih dari tanggal jatuh tempo
        $tanggalPembayaran = Carbon::parse('2024-10-31')->startOfDay();
        $selisihHari = $tanggalPembayaran->diffInDays($tanggalJatuhTempo, false);
        if ($tanggalPembayaran->greaterThan($tanggalJatuhTempo)) {
            $keterangan = 'Terlambat ' . abs($selisihHari) . ' hari';
        } elseif ($tanggalPembayaran->equalTo($tanggalJatuhTempo)) {
            $keterangan = 'Pembayaran tepat di hari jatuh tempo';
        } else {
            $keterangan = $selisihHari . ' hari tersisa';
        }

        // Assert untuk tanggal pembayaran yang lebih dari jatuh tempo
        $this->assertEquals('Terlambat 1 hari', $keterangan); // Pada tanggal 31, seharusnya terlambat 1 hari
    }
}
