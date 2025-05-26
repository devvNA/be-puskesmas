@extends('layouts.admin')

@section('title', 'Data Pasien')
@section('page-title', 'Manajemen Pasien')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Data Pasien</h1>
        <a href="{{ route('admin.pasien.create') }}" class="btn btn-success d-flex align-items-center gap-2 shadow-sm" style="background-color: #11894A; border: none;">
            <i class="fas fa-plus-circle"></i> Tambah Pasien
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-danger border-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Form Pencarian -->
    <div class="card shadow-sm mb-4 border-0 rounded-3 overflow-hidden">
        <div class="card-body">
            <form action="{{ route('admin.pasien.search') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0"
                        placeholder="Cari nama pasien, No RM, NIK, No BPJS, atau No Telepon" value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-success px-4" style="background-color: #11894A; border: none;">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Pasien -->
    <div class="card shadow-sm mb-4 border-0 rounded-3 overflow-hidden">
        <div class="card-header py-3 d-flex align-items-center" style="background-color: #11894A;">
            <h6 class="m-0 fw-bold text-white">
                <i class="fas fa-users me-2"></i> Daftar Pasien
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" width="5%">No</th>
                            <th width="10%">No. RM</th>
                            <th width="16%">Nama</th>
                            <th width="10%">No. BPJS</th>
                            <th width="10%">Jenis</th>
                            <th width="12%">NIK</th>
                            <th width="12%">No. HP</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien as $key => $item)
                        <tr>
                            <td class="ps-3">{{ $pasien->firstItem() + $key }}</td>
                            <td><span class="badge bg-light text-dark fw-normal border">{{ $item->no_rm ?? '-' }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                    @else
                                    <div class="avatar-placeholder bg-secondary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-secondary fa-sm"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <span class="fw-medium">{{ $item->nama }}</span>
                                        <div class="small text-muted">{{ date('d/m/Y', strtotime($item->tanggal_lahir)) }} • {{ $item->jenis_kelamin }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->no_bpjs)
                                <span class="badge bg-info text-dark">{{ $item->no_bpjs }}</span>
                                @else
                                <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->jenis == 'Reguler (BPJS)')
                                <span class="badge bg-primary">{{ $item->jenis }}</span>
                                @else
                                <span class="badge bg-warning text-dark">{{ $item->jenis }}</span>
                                @endif
                            </td>
                            <td>{{ $item->nik ?? '-' }}</td>
                            <td>{{ $item->no_telepon ?? '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.pasien.show', $item->id) }}" class="btn btn-sm btn-info px-3 py-2" data-bs-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pasien.edit', $item->id) }}" class="btn btn-sm btn-warning px-3 py-2" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pasien.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 py-2 delete-btn" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center py-5">
                                    <i class="fas fa-user-slash fa-4x text-muted mb-4"></i>
                                    <h5 class="fw-medium">Tidak ada data pasien</h5>
                                    <p class="text-muted">Belum ada data pasien yang terdaftar</p>
                                    <a href="{{ route('admin.pasien.create') }}" class="btn btn-success mt-2" style="background-color: #11894A; border: none;">
                                        <i class="fas fa-plus-circle me-1"></i> Tambah Pasien Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3">
                {{ $pasien->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Konfirmasi hapus dengan SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data pasien akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#11894A',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Aktivasi Tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });
</script>
@endpush
@endsection