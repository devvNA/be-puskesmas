@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('css')
<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card .card-body {
        padding: 1.5rem;
    }

    .stat-card .icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }

    .stat-card .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .stat-card .display-4 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-card .link {
        font-size: 0.9rem;
        text-decoration: none;
    }

    .stat-card .link:hover {
        text-decoration: underline;
    }

    .welcome-card {
        background: linear-gradient(135deg, #11894A 0%, #0a7a50 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .activity-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .timeline {
        position: relative;
        padding: 0;
        list-style: none;
    }

    .timeline-item {
        position: relative;
        padding-left: 50px;
        margin-bottom: 20px;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .timeline-content {
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .timeline-item:last-child .timeline-content {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>
@endpush

@section('content')
<div class="welcome-card">
    <h3 class="mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
    <p class="mb-0">Selamat datang kembali di Sistem Informasi Puskesmas Kluwut. Hari ini adalah
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}.
    </p>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title">Total Pasien</h5>
                        <h2 class="display-4">{{ App\Models\Pasien::count() }}</h2>
                        <a href="{{ route('admin.pasien.index') }}" class="link text-white">Lihat Detail →</a>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body" style="background-color: #cd1daa;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title">Total Dokter</h5>
                        <h2 class="display-4">{{ App\Models\Dokter::count() }}</h2>
                        <a href="{{ route('admin.dokter.index') }}" class="link text-white">Lihat Detail →</a>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body" style="background-color: #18b469;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title">Total Poli</h5>
                        <h2 class="display-4">{{ App\Models\Poli::count() }}</h2>
                        <a href="{{ route('admin.poli.index') }}" class="link text-white">Lihat Detail →</a>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title">Rekam Medis</h5>
                        <h2 class="display-4">{{ App\Models\RekamMedis::count() }}</h2>
                        <a href="{{ route('admin.rekam-medis.index') }}" class="link text-white">Lihat Detail →</a>
                    </div>
                    <div class="icon">
                        <i class="fas fa-notes-medical"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="chart-container">
            <h4 class="mb-4">Statistik Kunjungan Pasien</h4>
            <div style="position: relative; height: 300px;">
                <canvas id="visitChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="chart-container">
            <h4 class="mb-4">Status Kehadiran</h4>
            <div style="position: relative; height: 300px;">
                <canvas id="chartKehadiran"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h5 class="card-title">Antrian Terkini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>No. Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A-12</td>
                                <td>Ahmad Rizki</td>
                                <td>Poli Umum</td>
                                <td>dr. Hendra Wijaya</td>
                                <td><span class="badge bg-success">Sedang Diperiksa</span></td>
                            </tr>
                            <tr>
                                <td>A-13</td>
                                <td>Siti Aminah</td>
                                <td>Poli Umum</td>
                                <td>dr. Hendra Wijaya</td>
                                <td><span class="badge bg-warning">Menunggu</span></td>
                            </tr>
                            <tr>
                                <td>B-05</td>
                                <td>Diana Putri</td>
                                <td>Poli Gigi</td>
                                <td>drg. Maya Sari</td>
                                <td><span class="badge bg-success">Sedang Diperiksa</span></td>
                            </tr>
                            <tr>
                                <td>B-06</td>
                                <td>Hendra Wijaya</td>
                                <td>Poli Gigi</td>
                                <td>drg. Maya Sari</td>
                                <td><span class="badge bg-warning">Menunggu</span></td>
                            </tr>
                            <tr>
                                <td>C-08</td>
                                <td>Rina Agustina</td>
                                <td>Poli KIA</td>
                                <td>dr. Anisa Paramita</td>
                                <td><span class="badge bg-warning">Menunggu</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h5 class="card-title">Aktivitas Terkini</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Pendaftaran Pasien Baru</h6>
                            <p class="text-muted">Rina Agustina telah terdaftar sebagai pasien baru</p>
                            <small class="text-muted">10 menit yang lalu</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-primary">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Rekam Medis Diperbarui</h6>
                            <p class="text-muted">dr. Hendra Wijaya memperbarui rekam medis Ahmad Rizki</p>
                            <small class="text-muted">30 menit yang lalu</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-warning">
                            <i class="fas fa-pills"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Resep Obat Dikeluarkan</h6>
                            <p class="text-muted">Resep obat untuk Diana Putri telah dikeluarkan</p>
                            <small class="text-muted">1 jam yang lalu</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-info">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Jadwal Dokter Diperbarui</h6>
                            <p class="text-muted">dr. Anisa Paramita menambahkan jadwal praktik baru</p>
                            <small class="text-muted">2 jam yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var visitCtx = document.getElementById('visitChart').getContext('2d');
    new Chart(visitCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            datasets: [{
                label: 'Kunjungan Pasien',
                data: [30, 25, 40, 35, 50, 45, 60],
                borderColor: '#11894A',
                backgroundColor: 'rgba(17,137,74,0.2)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    var statusCtx = document.getElementById('chartKehadiran').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Tidak Hadir'],
            datasets: [{
                data: [75, 25],
                backgroundColor: ['#11894A', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
@endpush
