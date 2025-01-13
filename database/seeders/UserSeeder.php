<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            [
                'name' => 'Yoyo',
                'username' => 'admin',
                'nama_toko' => 'New Spon',
                'password' => Hash::make('admin'),
                'role_id' => 1,
                'toko_id' => 1,
            ],
            [
                'name' => 'Yoyo 2',
                'username' => 'admin2',
                'nama_toko' => 'New Spon 2',
                'password' => Hash::make('admin2'),
                'role_id' => 1,
                'toko_id' => 2,
            ],

        ];

        // $data = [
        //     [
        //         'name' => 'Admin Toko A',
        //         'username' => 'admin_toko_a',
        //         'nama_toko' => 'Toko A',
        //         'password' => Hash::make('password123'),
        //         'role_id' => 1,
        //         'toko_id' => 1,
        //     ],
        //     [
        //         'name' => 'Kasir Toko A',
        //         'username' => 'kasir_toko_a',
        //         'nama_toko' => 'Toko A',
        //         'password' => Hash::make('password123'),
        //         'role_id' => 2,
        //         'toko_id' => 1,
        //     ],
        //     [
        //         'name' => 'Admin Toko B',
        //         'username' => 'admin_toko_b',
        //         'nama_toko' => 'Toko B',
        //         'password' => Hash::make('password123'),
        //         'role_id' => 1,
        //         'toko_id' => 2,
        //     ],
        //     [
        //         'name' => 'Kasir Toko B',
        //         'username' => 'kasir_toko_b',
        //         'nama_toko' => 'Toko B',
        //         'password' => Hash::make('password123'),
        //         'role_id' => 2,
        //         'toko_id' => 2,
        //     ]
        // ];

        foreach ($data as $value) {
            User::create([
                'name' => $value['name'],
                'username' => $value['username'],
                'nama_toko' => $value['nama_toko'],
                'password' => $value['password'],
                'role_id' => $value['role_id'],
                'toko_id' => $value['toko_id'],
            ]);
        }
    }
}