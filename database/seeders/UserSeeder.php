<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin SiDesa',
            'email' => 'Admin@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'approved',
            'role_id' => '1',
        ]);

        User::create([
            'name' => 'penduduk 1',
            'email' => 'penduduk1@gmail.com',
            'password' => bcrypt('penduduk123'),
            'status' => 'approved',
            'role_id' => '2',
        ]);
        Resident::create([
            'nik'=> '123456789012334',
            'name'=> 'penduduk 1',
            'gender'=> 'male',
            'date_of_birth'=> '2005-01-01',
            'place_of_birth'=> 'oslo',
            'address'=> 'oslo',
            'marital_status'=> 'single'
        ]);
    }
}
