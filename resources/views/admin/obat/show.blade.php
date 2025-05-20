@extends('layouts.admin')

@section('title', 'Detail Obat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Obat</h4>
            <div>
                <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit Obat
                </a>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Informasi Obat</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%" class="bg-light">Kode Obat</th>
                                <td>{{ $obat->kode_obat }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Nama Obat</th>
                                <td>{{ $obat->nama_obat }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Kategori / Jenis</th>
                                <td>{{ $obat->jenis_obat }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Satuan</th>
                                <td>{{ $obat->satuan }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Stok</th>
                                <td>
                                    @if($obat->stok <= 10)
                                        <span class="badge bg-danger">{{ $obat->stok }}</span>
                                        <small class="text-danger">(Stok rendah)</small>
                                        @else
                                        <span class="badge bg-success">{{ $obat->stok }}</span>
                                        @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Harga</th>
                                <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal Kadaluarsa</th>
                                <td>
                                    @if($obat->tanggal_kadaluarsa)
                                    {{ $obat->tanggal_kadaluarsa->format('d-m-Y') }}

                                    @if($obat->tanggal_kadaluarsa <= now())
                                        <span class="badge bg-danger ms-2">Sudah Kadaluarsa</span>
                                        @elseif($obat->tanggal_kadaluarsa <= now()->addMonths(3))
                                            <span class="badge bg-warning ms-2">Hampir Kadaluarsa</span>
                                            @endif
                                            @else
                                            <span class="text-muted">Tidak ada</span>
                                            @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Deskripsi</th>
                                <td>{{ $obat->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal Dibuat</th>
                                <td>{{ $obat->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Terakhir Diperbarui</th>
                                <td>{{ $obat->updated_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Statistik Penggunaan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 p-3 border rounded bg-light">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-notes-medical text-primary me-2"></i>
                            <h6 class="mb-0">Rekam Medis</h6>
                        </div>
                        <p class="mb-0">
                            <span class="fw-bold h4">{{ $obat->rekamMedis ? $obat->rekamMedis->count() : 0 }}</span>
                            <span class="text-muted ms-2">kali diresepkan</span>
                        </p>
                    </div>

                    <div class="p-3 border rounded bg-light">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-history text-primary me-2"></i>
                            <h6 class="mb-0">Status Stok</h6>
                        </div>
                        <div class="progress mb-2" style="height: 10px;">
                            @php
                            $stockPercentage = min(100, ($obat->stok / 100) * 100);
                            $progressClass = $obat->stok <= 10 ? 'bg-danger' : ($obat->stok <= 20 ? 'bg-warning' : 'bg-success' );
                                    @endphp
                                    <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $stockPercentage }}%"
                                    aria-valuenow="{{ $obat->stok }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <small class="text-muted">
                        Stok saat ini: <span class="fw-bold">{{ $obat->stok }}</span> {{ $obat->satuan }}
                    </small>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit Obat
                    </a>
                    <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-1"></i> Hapus Obat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection