<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = [
            'Sampah menumpuk di pinggir jalan',
            'Jalan berlubang di depan sekolah dasar',
            'Lampu penerangan jalan mati total',
            'Saluran air tersumbat di depan rumah warga',
            'Fasilitas balai desa mulai rusak',
            'Pohon tumbang menutup akses jalan',
            'Got mampet dan bau saat hujan',
            'Tiang listrik miring membahayakan',
            'Pasar desa kurang tertata',
            'Air PDAM keruh dan berbau',
            'Lapangan sepak bola rusak parah',
            'Sarang tawon di halaman balai desa',
            'Penerangan gang gelap gulita',
            'Jembatan bambu mulai rapuh',
            'Sungai penuh sampah meluap',
            'Pengeras suara masjid sering mati',
            'Drainase depan rumah cepat penuh',
            'Jalan setapak rusak diterjang banjir',
            'Sampah plastik dibakar sembarangan',
            'Kubangan air di persimpangan',
            'Gerbang masuk desa rusak',
            'Papan nama jalan hilang',
            'Sarana posyandu kurang lengkap',
            'Saluran irigasi tersumbat lumpur',
            'Lampu taman mati malam hari',
            'Jembatan penghubung antar banjar rusak',
            'Perbaikan jalan aspal menunggu lama',
            'Selokan depan kantor desa mampet',
            'Jaringan listrik aut yang sering drop',
            'Rumput liar menutupi bahu jalan',
        ];

        $contents = [
            'Mohon dicek kembali, kondisi sudah cukup mengganggu warga di sekitar.',
            'Hal ini sudah berlangsung lama dan belum ada tindakan dari pihak terkait.',
            'Warga sangat berharap ada perbaikan secepatnya agar tidak membahayakan.',
            'Kejadian tersebut mengganggu aktivitas sehari-hari warga setempat.',
            'Mohon segera ditindaklanjuti demi kenyamanan dan keamanan bersama.',
        ];

        $statusPool = ['completed', 'completed', 'processing', 'confirmed', 'rejected'];

        foreach (range(1, 35) as $i) {
            $residentId = ($i % 11) + 1;
            $title = $titles[($i - 1) % count($titles)];
            $status = $statusPool[($i - 1) % count($statusPool)];

            if (Complaint::where('title', $title)->where('resident_id', $residentId)->exists()) {
                continue;
            }

            $date = Carbon::now()->subMonths(($i - 1) % 8)->subDays((($i - 1) * 7) % 28)->subHours((($i - 1) * 3) % 12);

            $complaint = [
                'resident_id' => $residentId,
                'title' => $title,
                'content' => $contents[($i - 1) % count($contents)],
                'status' => $status,
                'photo_prove' => null,
                'complaint_date' => $date,
            ];

            if (in_array($status, ['completed', 'processing', 'rejected'])) {
                $complaint['response'] = 'Laporan diterima, tim kami sedang menindaklanjuti laporan Anda.';
            }

            Complaint::create($complaint);
        }
    }
}