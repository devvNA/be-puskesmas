@extends('layouts.admin')

@section('title', 'Manajemen Dokter')
@section('page-title', 'Manajemen Dokter')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Dokter</h5>
                    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Dokter
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="15%">Foto</th>
                                    <th width="20%">Nama</th>
                                    <th width="15%">Spesialisasi</th>
                                    <th width="15%">Poli</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokter as $key => $item)
                                    <tr>
                                        <td>{{ $dokter->firstItem() + $key }}</td>
                                        <td>
                                            @if ($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                                    class="img-thumbnail"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/80x80?text=No+Image" alt="No Image"
                                                    class="img-thumbnail">
                                            @endif
                                        </td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->spesialisasi }}</td>
                                        <td>{{ $item->poli->nama }}</td>
                                        <td>
                                            @if ($item->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($item->status == 'cuti')
                                                <span class="badge bg-warning text-dark">Cuti</span>
                                            @else
                                                <span class="badge bg-danger">Off</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.dokter.show', $item->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.dokter.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('admin.dokter.destroy', $item->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data dokter</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $dokter->links() }}
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
                    text: "Data dokter akan dihapus! Semua jadwal yang terkait dengan dokter ini juga akan dihapus.",
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
