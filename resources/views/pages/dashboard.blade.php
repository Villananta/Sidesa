@extends('layout.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span class="text-muted small">{{ $todayLabel }}</span>
    </div>

    @php
        $statusBadge = function ($status) {
            return [
                'rejected' => ['danger', 'Ditolak'],
                'confirmed' => ['secondary', 'Diterima'],
                'processing' => ['warning', 'Diproses'],
                'completed' => ['success', 'Selesai'],
            ][$status] ?? ['secondary', $status];
        };
    @endphp

    @if ($isAdmin)
        {{-- ===================== DASHBOARD ADMIN ===================== --}}
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Penduduk Aktif</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalResidents }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pengaduan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalComplaints }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sedang Diproses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $processingCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengaduan Selesai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tren Pengaduan per Bulan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Distribusi Status Pengaduan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel pengaduan terbaru --}}
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Pengaduan Terbaru</h6>
                        <a href="{{ route('complaint.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-right fa-sm"></i> Semua Pengaduan
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hovered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengadu</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentComplaints as $complaint)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $complaint->resident->name ?? '-' }}</td>
                                        <td>{{ $complaint->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($complaint->complaint_date)->format('d-m-Y') }}</td>
                                        <td>
                                            @php [$badge, $label] = $statusBadge($complaint->status); @endphp
                                            <span class="badge badge-{{ $badge }}">{{ $label }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"><p class="text-center pt-3">Belum ada pengaduan.</p></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if ($hasResident)
            {{-- ===================== DASHBOARD USER (WARGA) ===================== --}}
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pengaduan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalComplaints }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sedang Diproses</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $processingCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejectedCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-ban fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Pengaduan Saya</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Pengaduan Terbaru Saya</h6>
                            <a href="{{ route('complaint.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-arrow-right fa-sm"></i> Semua Pengaduan
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hovered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentComplaints as $complaint)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $complaint->title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($complaint->complaint_date)->format('d-m-Y') }}</td>
                                            <td>
                                                @php [$badge, $label] = $statusBadge($complaint->status); @endphp
                                                <span class="badge badge-{{ $badge }}">{{ $label }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"><p class="text-center pt-3">Belum ada pengaduan.</p></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Akun belum terhubung dengan data penduduk --}}
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body text-center pt-5 pb-5">
                            <i class="fas fa-user-slash fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-800">Akun Belum Terkait Data Penduduk</h5>
                            <p class="text-muted">Silakan hubungi admin untuk mengaitkan akun Anda dengan data penduduk terlebih dahulu.</p>
                            <a href="{{ route('complaint.index') }}" class="btn btn-primary">
                                <i class="fas fa-bullhorn fa-sm"></i> Ke Halaman Pengaduan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusNames = { confirmed: 'Diterima', processing: 'Diproses', completed: 'Selesai', rejected: 'Ditolak' };
        const statusColors = { confirmed: '#858796', processing: '#f6c23e', completed: '#1cc88a', rejected: '#e74a3b' };

        const trendEl = document.getElementById('trendChart');
        if (trendEl) {
            new Chart(trendEl, {
                type: 'line',
                data: {
                    labels: @json($trendLabels ?? []),
                    datasets: [{
                        label: 'Jumlah Pengaduan',
                        data: @json($trendValues ?? []),
                        lineTension: 0.3,
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointBorderColor: 'rgba(78, 115, 223, 1)',
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        xAxes: [{ gridLines: { display: false }, ticks: { maxTicksLimit: 8 } }],
                        yAxes: [{
                            ticks: { beginAtZero: true, precision: 0 },
                            gridLines: { color: 'rgb(234, 236, 244)', zeroLineColor: 'rgb(234, 236, 244)' }
                        }]
                    },
                    tooltips: {
                        backgroundColor: 'rgb(255,255,255)',
                        bodyFontColor: '#858796',
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                    },
                }
            });
        }

        const statusEl = document.getElementById('statusChart');
        if (statusEl) {
            const counts = @json($statusCounts ?? []);
            const labels = Object.keys(counts).map(k => statusNames[k] || k);
            const data = Object.keys(counts).map(k => counts[k]);
            const colors = Object.keys(counts).map(k => statusColors[k] || '#858796');

            new Chart(statusEl, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        hoverBackgroundColor: colors,
                        hoverBorderColor: 'rgba(234, 236, 244, 1)',
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: true, position: 'bottom' },
                    tooltips: {
                        backgroundColor: 'rgb(255,255,255)',
                        bodyFontColor: '#858796',
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                    },
                }
            });
        }
    });
</script>
@endpush