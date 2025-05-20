@extends('layouts.admin')

@section('title', 'Pencarian Pasien')
@section('page-title', 'Pencarian Pasien')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hasil Pencarian: "{{ $keyword }}"</h5>
                    <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('admin.rekam-medis.search') }}" method="GET" class="d-flex">
                                <input type="text" name="keyword" class="form-control me-2"
                                    placeholder="Cari pasien (Nama/No.RM/NIK)..." value="{{ $keyword }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="20%">Nama Pasien</th>
                                    <th width="15%">No. Rekam Medis</th>
                                    <th width="15%">NIK</th>
                                    <th width="15%">Jenis Kelamin</th>
                                    <th width="10%">Tanggal Lahir</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pasien as $key => $item)
                                    <tr>
                                        <td>{{ $pasien->firstItem() + $key }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->no_rm }}</td>
                                        <td>{{ $item->nik ?? '-' }}</td>
                                        <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->tanggal_lahir)) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.rekam-medis.pasien', $item->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-list me-1"></i> Riwayat
                                                </a>
                                                <a href="{{ route('admin.rekam-medis.create') }}?pasien_id={{ $item->id }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus-circle me-1"></i> Rekam Medis Baru
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ditemukan data pasien dengan kata kunci
                                            "{{ $keyword }}"</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $pasien->appends(['keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
