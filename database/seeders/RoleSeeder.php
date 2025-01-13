<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $role = [
            [
                'nama_role' => 'Admin',
            ],
            [
                'nama_role' => 'Kasir',
            ]
        ];

        foreach ($role as $value) {
            Role::create([
                'nama_role' => $value['nama_role'],
            ]);
        }
    }
}
