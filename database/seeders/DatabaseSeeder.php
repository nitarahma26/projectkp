<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Mendefinisikan role yang ada
        $roles = [
            [
                'nama' => 'Superadmin',
            ],
            [
                'nama' => 'Admin',
            ],
            [
                'nama' => 'Kasir',
            ],
        ];

        // Menyimpan role ke dalam database
        foreach ($roles as $role) {
            Role::create($role);
        }

        // Data pengguna yang akan dimasukkan ke dalam database
        $data = [
            [
                'nama' => 'Superadmin',
                'email' => 'superadmin@gmail',
                'password' => bcrypt('1'),
                'role_id' => 1, // ID Superadmin
            ],
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail',
                'password' => bcrypt('1'),
                'role_id' => 2, // ID Admin
            ],
            [
                'nama' => 'Kasir 1',
                'email' => 'kasir1@gmail',
                'password' => bcrypt('1'),
                'role_id' => 3, // ID Kasir
            ],
        ];

        // Menyimpan pengguna ke dalam database
        foreach ($data as $user) {
            User::create($user);
        }
    }
}
