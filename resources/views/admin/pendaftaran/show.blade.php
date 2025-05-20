@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')
@section('page-title', 'Detail')



@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                        <h4 class="mb-0">Detail Pendaftaran</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.pendaftaran.edit', $pendaftaran->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-3 mb-3">
                            <!-- Informasi Pendaftaran -->
                            <div class="col-md-6">
                                <div class="card mb-0">
                                    <div class="card-header bg-light py-2 px-3">
                                        <h5 class="mb-0">Informasi Pendaftaran</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="40%" class="fw-bold">No. Antrian</td>
                                                <td>: {{ $pendaftaran->no_antrian }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tanggal Pendaftaran</td>
                                                <td>:
                                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_pendaftaran)->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status Kehadiran</td>
                                                <td>
                                                    : @if ($pendaftaran->status_kehadiran == 'sudah hadir')
                                                        <span class="badge bg-success">Sudah Hadir</span>
                                                        @if ($pendaftaran->waktu_hadir)
                                                            <div class="text-muted fs-12 mt-1">
                                                                {{ \Carbon\Carbon::parse($pendaftaran->waktu_hadir)->format('d/m/Y H:i') }}
                                                            </div>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-warning text-dark">Belum Hadir</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Keterangan</td>
                                                <td>: {{ $pendaftaran->keterangan ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Pasien -->
                            <div class="col-md-6">
                                <div class="card mb-0">
                                    <div class="card-header bg-light py-2 px-3">
                                        <h5 class="mb-0">Informasi Pasien</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="40%" class="fw-bold">Nama Pasien</td>
                                                <td>: {{ $pendaftaran->pasien->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">No. RM</td>
                                                <td>: {{ $pendaftaran->pasien->no_rm }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">NIK</td>
                                                <td>: {{ $pendaftaran->pasien->nik ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tanggal Lahir</td>
                                                <td>:
                                                    {{ \Carbon\Carbon::parse($pendaftaran->pasien->tanggal_lahir)->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Alamat</td>
                                                <td>: {{ $pendaftaran->pasien->alamat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Kontak</td>
                                                <td>: {{ $pendaftaran->pasien->no_telepon ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Poli & Dokter -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="card mb-0">
                                    <div class="card-header bg-light py-2 px-3">
                                        <h5 class="mb-0">Poli & Dokter</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="40%" class="fw-bold">Poli</td>
                                                <td>: {{ $pendaftaran->poli->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Dokter</td>
                                                <td>: {{ $pendaftaran->dokter ? $pendaftaran->dokter->nama : '-' }}</td>
                                            </tr>
                                            @if ($pendaftaran->dokter)
                                                <tr>
                                                    <td class="fw-bold">Spesialisasi</td>
                                                    <td>: {{ $pendaftaran->dokter->spesialisasi ?? '-' }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($pendaftaran->status_kehadiran == 'belum hadir')
                            <div class="mt-2">
                                <form action="{{ route('admin.pendaftaran.status', $pendaftaran->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status_kehadiran" value="sudah hadir">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check-circle me-1"></i> Tandai Hadir
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('css')
    <style>
        .fs-12 {
            font-size: 12px;
        }
    </style>
@endpush
