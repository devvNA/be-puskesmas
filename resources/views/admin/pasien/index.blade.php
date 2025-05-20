@extends('layouts.admin')

@section('title', 'Data Pasien')
@section('page-title', 'Manajemen Pasien')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pasien</h1>
        <a href="{{ route('admin.pasien.create') }}" class="btn btn-sm btn-success shadow-sm" style="background-color: #11894A; border-color: #11894A;">
            <i class="fas fa-plus-circle me-1"></i> Tambah Pasien
        </a>
    </div>

    <!-- Pesan Sukses/Error
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif -->

    <!-- Form Pencarian -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pasien.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pasien, No RM, atau NIK" value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-success" style="background-color: #11894A; border-color: #11894A;">
                        <i class="fas fa-search fa-sm"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Pasien -->
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #11894A; color: white;">
            <h6 class="m-0 font-weight-bold">Daftar Pasien</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead style="background-color: #E7E7E7; color: black;">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="20%">No. RM</th>
                            <th width="20%">Nama</th>
                            <th width="5%">Email</th>
                            <th width="15%">NIK</th>
                            <th width="20%">Alamat</th>
                            <th width="10%">No. HP</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien as $key => $item)
                        <tr>
                            <td class="text-center">{{ $pasien->firstItem() + $key }}</td>
                            <td>{{ $item->no_rm }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ Str::limit($item->alamat, 30) }}</td>
                            <td>{{ $item->no_telepon }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.pasien.show', $item->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pasien.edit', $item->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pasien.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">Tidak ada data pasien</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
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
