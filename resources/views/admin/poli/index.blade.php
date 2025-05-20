@extends('layouts.admin')

@section('title', 'Manajemen Poli')
@section('page-title', 'Manajemen Poli')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Poli</h5>
                    <a href="{{ route('admin.poli.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Poli
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="20%">Nama Poli</th>
                                    <th width="30%">Deskripsi</th>
                                    <th width="15%">Kuota Harian</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($poli as $key => $item)
                                    <tr>
                                        <td>{{ $poli->firstItem() + $key }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->deskripsi ?? '-' }}</td>
                                        <td>{{ $item->kuota_harian }} pasien</td>
                                        <td>
                                            @if ($item->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.poli.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.jadwal.index', $item->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('admin.poli.destroy', $item->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data poli</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $poli->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Delete confirmation
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data poli akan dihapus! Semua jadwal dan dokter yang terkait dengan poli ini juga akan dihapus.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush
