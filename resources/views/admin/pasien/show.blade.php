@extends('layouts.admin')

@section('title', 'Detail Pasien')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pasien</h1>
        <div>
            <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="btn btn-sm btn-warning shadow-sm me-2">
                <i class="fas fa-edit fa-sm text-dark me-1"></i> <b>Edit</b>
            </a>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> <b>Kembali</b>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Pasien -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color: #11894A; color: white;">
                    <h6 class="m-0 font-weight-bold">Informasi Pasien</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($pasien->foto)
                        <img src="{{ asset('storage/' . $pasien->foto) }}" alt="Foto {{ $pasien->nama }}"
                            class="img-fluid rounded-circle shadow border" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                        <div class="avatar-placeholder d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto shadow" style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-5x text-secondary"></i>
                        </div>
                        @endif
                        <h5 class="mt-3 mb-0 font-weight-bold">{{ $pasien->nama }}</h5>
                        <p class="text-muted small">{{ $pasien->no_rm }}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%"><i class="fas" style="color: #11894A;"></i>NIK</th>
                                <td width="65%">{{ $pasien->nik }}</td>
                            </tr>
                            <tr>
                                <th width="35%"><i class="fas" style="color: #11894A;"></i>Email</th>
                                <td width="65%">{{ $pasien->email }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas"></i>Tanggal Lahir</th>
                                <td>{{ date('d F Y', strtotime($pasien->tanggal_lahir)) }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas"></i>Jenis Kelamin</th>
                                <td>{{ $pasien->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas"></i>Alamat</th>
                                <td>{{ $pasien->alamat }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas"></i>No.Telepon</th>
                                <td>
                                    <a href="tel:{{ $pasien->no_telepon }}" class="text-decoration-none">
                                        {{ $pasien->no_telepon }}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <a href="https://wa.me/{{ str_replace('0', '62', substr($pasien->no_telepon, 0, 1)) . substr($pasien->no_telepon, 1) }}?text=Halo {{ $pasien->nama }}, saya dari Puskesmas Kluwung..."
                           class="btn btn-success" style="background-color: #25D366; border-color: #25D366;" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i> Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Riwayat Pendaftaran -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #11894A; color: white;">
                    <h6 class="m-0 font-weight-bold">Riwayat Pendaftaran</h6>
                    <a href="{{ route('admin.pendaftaran.create') }}?pasien_id={{ $pasien->id }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus fa-sm me-1"></i> Tambah Pendaftaran
                    </a>
                </div>
                <div class="card-body">
                    @if($pasien->pendaftaran->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pasien->pendaftaran as $pendaftaran)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($pendaftaran->tanggal_pendaftaran)) }}</td>
                                    <td>{{ $pendaftaran->poli->nama }}</td>
                                    <td>{{ $pendaftaran->dokter->nama }}</td>
                                    <td>
                                        <span class="badge {{ $pendaftaran->status_kehadiran == 'sudah hadir' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($pendaftaran->status_kehadiran) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-calendar-times fa-4x text-muted"></i>
                        </div>
                        <p class="mb-0">Belum ada riwayat pendaftaran</p>
                        <small class="text-muted">Silakan tambahkan pendaftaran baru untuk pasien ini</small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Rekam Medis -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #11894A; color: white;">
                    <h6 class="m-0 font-weight-bold">Riwayat Rekam Medis</h6>
                    <a href="{{ route('admin.rekam-medis.pasien', $pasien->id) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-clipboard-list fa-sm me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($pasien->rekamMedis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%">Dokter</th>
                                    <th width="45%">Diagnosa</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pasien->rekamMedis->take(5) as $rekamMedis)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($rekamMedis->tanggal)) }}</td>
                                    <td>{{ $rekamMedis->dokter->nama }}</td>
                                    <td>{{ Str::limit($rekamMedis->diagnosa, 50) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.rekam-medis.show', $rekamMedis->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.rekam-medis.qrcode', $rekamMedis->id) }}" class="btn btn-sm btn-success" style="background-color: #11894A; border-color: #11894A;">
                                            <i class="fas fa-qrcode"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pasien->rekamMedis->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.rekam-medis.pasien', $pasien->id) }}" class="btn btn-sm btn-success" style="background-color: #11894A; border-color: #11894A;">
                            Lihat {{ $pasien->rekamMedis->count() - 5 }} Rekam Medis Lainnya
                        </a>
                    </div>
                    @endif

                    @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-notes-medical fa-4x text-muted"></i>
                        </div>
                        <p class="mb-0">Belum ada riwayat rekam medis</p>
                        <small class="text-muted">Rekam medis akan dibuat setelah pasien menjalani pemeriksaan</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
