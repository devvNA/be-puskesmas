@extends('layouts.admin')

@section('title', 'Jadwal Poli ' . $poli->nama)
@section('page-title', 'Jadwal')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Jadwal Poli {{ $poli->nama }}</h5>
                    <div>
                        <a href="{{ route('admin.jadwal.create', $poli->id) }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Jadwal
                        </a>
                        <a href="{{ route('admin.poli.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="30%">Nama Poli</th>
                                    <td width="70%">{{ $poli->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $poli->deskripsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kuota Harian</th>
                                    <td>{{ $poli->kuota_harian }} pasien</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($poli->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="15%">Hari</th>
                                    <th width="20%">Jam Buka</th>
                                    <th width="20%">Jam Tutup</th>
                                    <th width="15%">Status</th>
                                    <th width="25%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwal as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->hari }}</td>
                                        <td>{{ date('H:i', strtotime($item->jam_buka)) }}</td>
                                        <td>{{ date('H:i', strtotime($item->jam_tutup)) }}</td>
                                        <td>
                                            @if ($item->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.jadwal.edit', [$poli->id, $item->id]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('admin.jadwal.destroy', [$poli->id, $item->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada jadwal tersedia</td>
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

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Delete confirmation
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Jadwal poli akan dihapus!",
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
