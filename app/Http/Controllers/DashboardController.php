<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected array $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    public function index()
    {
        $user = auth()->user();

        $data = $user->role->name === 'Admin'
            ? $this->adminData()
            : $this->userData($user);

        $data['todayLabel'] = $this->todayLabel();

        return view('pages.dashboard', $data);
    }

    protected function adminData(): array
    {
        return [
            'isAdmin' => true,
            'totalResidents' => Resident::where('status', 'aktif')->count(),
            'totalComplaints' => Complaint::count(),
            'processingCount' => Complaint::where('status', 'processing')->count(),
            'completedCount' => Complaint::where('status', 'completed')->count(),
            'statusCounts' => Complaint::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'trendLabels' => $this->trendLabels(),
            'trendValues' => $this->trendValues(),
            'recentComplaints' => Complaint::with('resident')
                ->latest('complaint_date')
                ->take(5)
                ->get(),
        ];
    }

    protected function userData($user): array
    {
        $resident = $user->resident;

        if (!$resident) {
            return [
                'isAdmin' => false,
                'hasResident' => false,
                'totalComplaints' => 0,
                'processingCount' => 0,
                'completedCount' => 0,
                'rejectedCount' => 0,
                'confirmedCount' => 0,
                'statusCounts' => collect(),
                'recentComplaints' => collect(),
            ];
        }

        return [
            'isAdmin' => false,
            'hasResident' => true,
            'totalComplaints' => Complaint::where('resident_id', $resident->id)->count(),
            'processingCount' => Complaint::where('resident_id', $resident->id)->where('status', 'processing')->count(),
            'completedCount' => Complaint::where('resident_id', $resident->id)->where('status', 'completed')->count(),
            'rejectedCount' => Complaint::where('resident_id', $resident->id)->where('status', 'rejected')->count(),
            'confirmedCount' => Complaint::where('resident_id', $resident->id)->where('status', 'confirmed')->count(),
            'statusCounts' => Complaint::where('resident_id', $resident->id)
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'recentComplaints' => Complaint::with('resident')
                ->where('resident_id', $resident->id)
                ->latest('complaint_date')
                ->take(5)
                ->get(),
        ];
    }

    protected function trendLabels(): array
    {
        $reference = $this->referenceDate();
        $labels = [];

        for ($i = 7; $i >= 0; $i--) {
            $date = $reference->copy()->subMonths($i);
            $labels[] = $this->months[$date->month - 1] . ' ' . $date->format('y');
        }

        return $labels;
    }

    protected function trendValues(): array
    {
        $reference = $this->referenceDate();
        $start = $reference->copy()->subMonths(7)->startOfMonth();

        $grouped = Complaint::where('complaint_date', '>=', $start)
            ->selectRaw("DATE_FORMAT(complaint_date, '%Y-%m') as bulan, count(*) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $values = [];

        for ($i = 7; $i >= 0; $i--) {
            $key = $reference->copy()->subMonths($i)->format('Y-m');
            $values[] = (int) ($grouped[$key] ?? 0);
        }

        return $values;
    }

    protected function referenceDate(): Carbon
    {
        return Carbon::parse(DB::selectOne('SELECT NOW() AS now')->now);
    }

    protected function todayLabel(): string
    {
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $date = Carbon::now('Asia/Jakarta');

        return $days[$date->dayOfWeek] . ', ' . $date->day . ' ' . $this->months[$date->month - 1] . ' ' . $date->year;
    }
}