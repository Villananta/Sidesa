<?php

namespace Database\Seeders;

use App\Models\Resident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = [
            [
                'nik' => '5104011234567890', 'name' => 'I Wayan Sudiarta', 'gender' => 'male',
                'place_of_birth' => 'Denpasar', 'date_of_birth' => '1980-05-12',
                'address' => 'Br. Teba, Kuta', 'religion' => 'hindu', 'marital_status' => 'married',
                'occupation' => 'Petani', 'phone' => '081234567801', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567891', 'name' => 'Ni Ketut Ratnawati', 'gender' => 'female',
                'place_of_birth' => 'Badung', 'date_of_birth' => '1985-11-02',
                'address' => 'Br. Pande, Kuta', 'religion' => 'hindu', 'marital_status' => 'married',
                'occupation' => 'Ibu Rumah Tangga', 'phone' => '081234567802', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567892', 'name' => 'Made Adi Putra', 'gender' => 'male',
                'place_of_birth' => 'Denpasar', 'date_of_birth' => '1992-03-18',
                'address' => 'Br. Anyar, Kuta', 'religion' => 'hindu', 'marital_status' => 'married',
                'occupation' => 'Wiraswasta', 'phone' => '081234567803', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567893', 'name' => 'Komang Rai Artawan', 'gender' => 'male',
                'place_of_birth' => 'Gianyar', 'date_of_birth' => '1998-07-25',
                'address' => 'Br. Kaja, Kuta', 'religion' => 'hindu', 'marital_status' => 'single',
                'occupation' => 'Karyawan Swasta', 'phone' => '081234567804', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567894', 'name' => 'Desak Putu Ayu', 'gender' => 'female',
                'place_of_birth' => 'Bangli', 'date_of_birth' => '2000-01-09',
                'address' => 'Br. Dinas Kauh, Kuta', 'religion' => 'hindu', 'marital_status' => 'single',
                'occupation' => 'Mahasiswa', 'phone' => '081234567805', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567895', 'name' => 'Ketut Suardana', 'gender' => 'male',
                'place_of_birth' => 'Tabanan', 'date_of_birth' => '1975-09-30',
                'address' => 'Br. Tengah, Kuta', 'religion' => 'hindu', 'marital_status' => 'married',
                'occupation' => 'Pedagang', 'phone' => '081234567806', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567896', 'name' => 'Ni Made Widianingsih', 'gender' => 'female',
                'place_of_birth' => 'Denpasar', 'date_of_birth' => '1990-12-14',
                'address' => 'Br. Semer, Kuta', 'religion' => 'hindu', 'marital_status' => 'married',
                'occupation' => 'Perawat', 'phone' => '081234567807', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567897', 'name' => 'Gede Ngurah Wibawa', 'gender' => 'male',
                'place_of_birth' => 'Karangasem', 'date_of_birth' => '1968-04-21',
                'address' => 'Br. Pangkung, Kuta', 'religion' => 'hindu', 'marital_status' => 'widower',
                'occupation' => null, 'phone' => '081234567808', 'status' => 'aktif',
            ],
            [
                'nik' => '5104011234567898', 'name' => 'Ni Luh Sri Wahyuni', 'gender' => 'female',
                'place_of_birth' => 'Jembrana', 'date_of_birth' => '1988-06-05',
                'address' => 'Br. Belong, Kuta', 'religion' => 'hindu', 'marital_status' => 'married',
                'occupation' => 'Guru', 'phone' => '081234567809', 'status' => 'pindahan',
            ],
            [
                'nik' => '5104011234567899', 'name' => 'I Nyoman Darmayasa', 'gender' => 'male',
                'place_of_birth' => 'Badung', 'date_of_birth' => '1945-02-11',
                'address' => 'Br. Beteng, Kuta', 'religion' => 'hindu', 'marital_status' => 'widower',
                'occupation' => null, 'phone' => '081234567810', 'status' => 'meninggal',
            ],
        ];

        foreach ($residents as $resident) {
            Resident::firstOrCreate(['nik' => $resident['nik']], $resident);
        }
    }
}