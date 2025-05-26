@extends('layouts.admin')

@section('title', 'Detail Pasien')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-sm btn-light rounded-circle me-3 shadow-sm border">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Detail Pasien</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="btn btn-warning d-flex align-items-center gap-2 shadow-sm">
                <i class="fas fa-edit"></i> Edit Data
            </a>
            <a href="{{ route('admin.pendaftaran.create') }}?pasien_id={{ $pasien->id }}" class="btn btn-success d-flex align-items-center gap-2 shadow-sm" style="background-color: #11894A; border: none;">
                <i class="fas fa-plus-circle"></i> Buat Pendaftaran
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Pasien -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header py-3 d-flex align-items-center" style="background-color: #11894A;">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-user-circle me-2"></i> Informasi Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($pasien->foto)
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ asset('storage/' . $pasien->foto) }}" alt="Foto {{ $pasien->nama }}"
                                class="rounded-circle shadow border" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        @else
                        <div class="avatar-placeholder d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto shadow mb-3" style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-4x text-secondary opacity-50"></i>
                        </div>
                        @endif
                        <h5 class="fw-bold mb-0">{{ $pasien->nama }}</h5>
                        <p class="text-muted mb-1">
                            <span class="badge bg-light text-dark fw-normal shadow-sm">{{ $pasien->no_rm ?? 'Belum memiliki No. RM' }}</span>
                        </p>

                        @if($pasien->jenis)
                        <span class="badge {{ $pasien->jenis == 'Reguler (BPJS)' ? 'bg-info text-dark' : 'bg-warning text-dark' }} mb-3">
                            {{ $pasien->jenis }}
                        </span>
                        @endif
                    </div>

                    <div class="border-top pt-3">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted"><i class="fas fa-id-card me-2 text-primary opacity-75"></i> NIK</div>
                                <div class="fw-medium">{{ $pasien->nik ?? '-' }}</div>
                            </div>

                            @if($pasien->no_bpjs)
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted"><i class="fas fa-hospital-user me-2 text-info opacity-75"></i> No. BPJS</div>
                                <div class="fw-medium">{{ $pasien->no_bpjs }}</div>
                            </div>
                            @endif

                            @if($pasien->hubungan_keluarga)
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted"><i class="fas fa-users me-2 text-primary opacity-75"></i> Hubungan Keluarga</div>
                                <div class="fw-medium">
                                    <span class="badge {{ $pasien->hubungan_keluarga == 'Kepala Keluarga' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $pasien->hubungan_keluarga }}
                                    </span>
                                </div>
                            </div>
                            @endif

                            <div class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted"><i class="fas fa-envelope me-2 text-success opacity-75"></i> Email</div>
                                <div class="fw-medium">{{ $pasien->email ?? '-' }}</div>
                            </div>

                            <div class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted"><i class="fas fa-calendar-alt me-2 text-warning opacity-75"></i> Tanggal Lahir</div>
                                <div class="fw-medium">
                                    {{ date('d F Y', strtotime($pasien->tanggal_lahir)) }}
                                    <span class="badge bg-light text-dark ms-1">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun</span>
                                </div>
                            </div>

                            <div class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted"><i class="fas fa-venus-mars me-2 text-danger opacity-75"></i> Jenis Kelamin</div>
                                <div class="fw-medium">{{ $pasien->jenis_kelamin }}</div>
                            </div>

                            @if($pasien->golongan_darah && $pasien->golongan_darah != '-')
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted"><i class="fas fa-tint me-2 text-danger"></i> Golongan Darah</div>
                                <div class="fw-medium">{{ $pasien->golongan_darah }}</div>
                            </div>
                            @endif

                            <div class="list-group-item px-0 py-3">
                                <div class="text-muted mb-1"><i class="fas fa-map-marker-alt me-2 text-secondary opacity-75"></i> Alamat</div>
                                <div class="fw-medium">{{ $pasien->alamat }}</div>
                                @if($pasien->rt || $pasien->rw || $pasien->provinsi)
                                <div class="small text-muted mt-1">
                                    @if($pasien->rt && $pasien->rw) RT {{ $pasien->rt }} / RW {{ $pasien->rw }} @endif
                                    @if($pasien->provinsi) • {{ $pasien->provinsi }} @endif
                                </div>
                                @endif
                            </div>

                            <div class="list-group-item px-0 py-3">
                                <div class="text-muted mb-1"><i class="fas fa-phone me-2 text-success opacity-75"></i> Kontak</div>
                                <div class="d-grid gap-2">
                                    <a href="tel:{{ $pasien->no_telepon }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-phone"></i> {{ $pasien->no_telepon ?? '-' }}
                                    </a>
                                    <a href="https://wa.me/{{ str_replace('0', '62', substr($pasien->no_telepon, 0, 1)) . substr($pasien->no_telepon, 1) }}?text=Halo {{ $pasien->nama }}, saya dari Puskesmas Kluwung..."
                                        class="btn btn-success d-flex align-items-center justify-content-center gap-2" style="background-color: #25D366; border: none;">
                                        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Riwayat Pendaftaran -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #11894A;">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-clipboard-list me-2"></i> Riwayat Pendaftaran
                    </h6>
                    <a href="{{ route('admin.pendaftaran.create') }}?pasien_id={{ $pasien->id }}" class="btn btn-sm btn-light d-flex align-items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($pasien->pendaftaran->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Tanggal</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pasien->pendaftaran as $pendaftaran)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-medium">{{ date('d M Y', strtotime($pendaftaran->tanggal_pendaftaran)) }}</div>
                                        <div class="small text-muted">{{ date('H:i', strtotime($pendaftaran->jam_pendaftaran)) }} WIB</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark fw-normal border px-3 py-2">
                                            <i class="fas fa-clinic-medical me-1 text-primary"></i> {{ $pendaftaran->poli->nama }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder bg-secondary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user-md text-secondary fa-sm"></i>
                                            </div>
                                            <div>{{ $pendaftaran->dokter->nama }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $pendaftaran->status_kehadiran == 'sudah hadir' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($pendaftaran->status_kehadiran) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="btn btn-sm btn-info px-3">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-calendar-times fa-4x text-muted opacity-25"></i>
                        </div>
                        <h6 class="fw-bold text-muted">Belum Ada Riwayat Pendaftaran</h6>
                        <p class="text-muted mb-3">Pasien belum pernah melakukan pendaftaran</p>
                        <a href="{{ route('admin.pendaftaran.create') }}?pasien_id={{ $pasien->id }}" class="btn btn-success" style="background-color: #11894A; border: none;">
                            <i class="fas fa-plus-circle me-1"></i> Buat Pendaftaran Baru
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Rekam Medis -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #11894A;">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-notes-medical me-2"></i> Riwayat Rekam Medis
                    </h6>
                    <a href="{{ route('admin.rekam-medis.pasien', $pasien->id) }}" class="btn btn-sm btn-light d-flex align-items-center gap-2">
                        <i class="fas fa-list"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($pasien->rekamMedis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" width="15%">Tanggal</th>
                                    <th width="20%">Dokter</th>
                                    <th width="45%">Diagnosa</th>
                                    <th class="text-end pe-3" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pasien->rekamMedis->take(5) as $rekamMedis)
                                <tr>
                                    <td class="ps-3">{{ date('d M Y', strtotime($rekamMedis->tanggal)) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder bg-secondary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user-md text-secondary fa-sm"></i>
                                            </div>
                                            <div>{{ $rekamMedis->dokter->nama }}</div>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($rekamMedis->diagnosa, 50) }}</td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.rekam-medis.show', $rekamMedis->id) }}" class="btn btn-sm btn-info px-3">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.rekam-medis.qrcode', $rekamMedis->id) }}" class="btn btn-sm btn-success px-3" style="background-color: #11894A; border: none;">
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pasien->rekamMedis->count() > 5)
                    <div class="p-3 text-center border-top">
                        <a href="{{ route('admin.rekam-medis.pasien', $pasien->id) }}" class="btn btn-outline-success" style="color: #11894A; border-color: #11894A;">
                            <i class="fas fa-file-medical me-1"></i> Lihat {{ $pasien->rekamMedis->count() - 5 }} Rekam Medis Lainnya
                        </a>
                    </div>
                    @endif

                    @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-notes-medical fa-4x text-muted opacity-25"></i>
                        </div>
                        <h6 class="fw-bold text-muted">Belum Ada Rekam Medis</h6>
                        <p class="text-muted mb-0">Rekam medis akan dibuat setelah pasien menjalani pemeriksaan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection