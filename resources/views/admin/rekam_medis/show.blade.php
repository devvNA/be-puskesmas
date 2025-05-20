@extends('layouts.admin')

@section('title', 'Detail Rekam Medis')
@section('page-title', 'Detail Rekam Medis')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Rekam Medis</h5>
                    <div>
                        <!-- <a href="{{ route('admin.rekam-medis.qrcode', $rekamMedis->id) }}" class="btn btn-info me-2">
                            <i class="fas fa-qrcode me-1"></i> QR Code
                        </a> -->
                        <a href="{{ route('admin.rekam-medis.edit', $rekamMedis->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header" style="background-color: #18b469; color: white;">
                                    <h6 class="mb-0">Data Pasien</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="30%">Nama Pasien</th>
                                            <td width="70%">: {{ $rekamMedis->pasien->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Rekam Medis</th>
                                            <td>: {{ $rekamMedis->pasien->no_rm }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>: {{ $rekamMedis->pasien->nik ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>: {{ date('d/m/Y', strtotime($rekamMedis->pasien->tanggal_lahir)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>:
                                                {{ $rekamMedis->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: {{ $rekamMedis->pasien->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon</th>
                                            <td>: {{ $rekamMedis->pasien->no_telepon ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header" style="background-color: #18b469; color: white;">
                                    <h6 class="mb-0">Data Pemeriksaan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="30%">Tanggal Periksa</th>
                                            <td width="70%">:
                                                {{ date('d/m/Y', strtotime($rekamMedis->tanggal_periksa)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dokter</th>
                                            <td>: {{ $rekamMedis->dokter->nama }}
                                                ({{ $rekamMedis->dokter->spesialisasi }})</td>
                                        </tr>
                                        <tr>
                                            <th>Poli</th>
                                            <td>: {{ $rekamMedis->poli->nama }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if ($rekamMedis->pendaftaran)
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header" style="background-color: #18b469; color: white;">
                                        <h6 class="mb-0">Data Pendaftaran</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <th width="30%">Tanggal Daftar</th>
                                                <td width="70%">:
                                                    {{ date('d/m/Y', strtotime($rekamMedis->pendaftaran->tanggal_pendaftaran)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>No. Antrian</th>
                                                <td>: {{ $rekamMedis->pendaftaran->no_antrian }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status Kehadiran</th>
                                                <td>:
                                                    @if ($rekamMedis->pendaftaran->status_kehadiran == 'sudah hadir')
                                                        <span class="badge bg-success">Sudah Hadir</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Belum Hadir</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header" style="background-color: #18b469; color: white;">
                                    <h6 class="mb-0">Riwayat Pemeriksaan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <strong>Keluhan:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            {{ $rekamMedis->keluhan }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <strong>Diagnosis:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            {{ $rekamMedis->diagnosis ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <strong>Tindakan:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            {{ $rekamMedis->tindakan ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <strong>Resep:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            {!! nl2br(e($rekamMedis->resep ?? '-')) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Catatan:</strong>
                                        </div>
                                        <div class="col-md-10">
                                            {{ $rekamMedis->catatan ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (count($rekamMedis->filePendukung) > 0)
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header" style="background-color: #18b469; color: white;">
                                        <h6 class="mb-0">File Pendukung</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No.</th>
                                                        <th width="30%">Nama File</th>
                                                        <th width="20%">Jenis File</th>
                                                        <th width="25%">Keterangan</th>
                                                        <th width="20%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rekamMedis->filePendukung as $key => $file)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $file->nama_file }}</td>
                                                            <td>{{ $file->jenis_file }}</td>
                                                            <td>{{ $file->keterangan ?? '-' }}</td>
                                                            <td>
                                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                                    class="btn btn-sm btn-info" target="_blank">
                                                                    <i class="fas fa-eye me-1"></i> Lihat
                                                                </a>
                                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                                    class="btn btn-sm btn-success" download>
                                                                    <i class="fas fa-download me-1"></i> Unduh
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Kunjungan Pasien</h5>
                    <a href="{{ route('admin.rekam-medis.pasien', $rekamMedis->pasien->id) }}" class="btn btn-primary">
                        <i class="fas fa-list me-1"></i> Lihat Semua Riwayat
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="15%">Tanggal Periksa</th>
                                    <th width="20%">Dokter</th>
                                    <th width="15%">Poli</th>
                                    <th width="25%">Diagnosis</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $riwayat = $rekamMedis->pasien
                                        ->rekamMedis()
                                        ->where('id', '!=', $rekamMedis->id)
                                        ->orderBy('tanggal_periksa', 'desc')
                                        ->take(5)
                                        ->get();
                                @endphp

                                @forelse($riwayat as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->tanggal_periksa)) }}</td>
                                        <td>{{ $item->dokter->nama }}</td>
                                        <td>{{ $item->poli->nama }}</td>
                                        <td>{{ $item->diagnosis ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.rekam-medis.show', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada riwayat kunjungan lainnya</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
