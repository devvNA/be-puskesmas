@extends('layouts.admin')

@section('title', 'Manajemen Rekam Medis')
@section('page-title', 'Manajemen Rekam Medis')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Rekam Medis</h5>
                    <a href="{{ route('admin.rekam-medis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Rekam Medis
                    </a>
                </div>

                <div class="card-body">
                    <!-- <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Fitur QR Code sekarang tersedia untuk setiap rekam medis. Klik ikon <i class="fas fa-qrcode"></i>
                        untuk membuat QR Code yang bisa digunakan untuk mengakses rekam medis dengan cepat.
                    </div> -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('admin.rekam-medis.search') }}" method="GET" class="d-flex">
                                <input type="text" name="keyword" class="form-control me-2"
                                    placeholder="Cari pasien (Nama/No.RM/NIK)..."
                                    value="{{ isset($keyword) ? $keyword : '' }}">
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
                                    <th width="15%">Tanggal Periksa</th>
                                    <th width="15%">Dokter</th>
                                    <th width="10%">Poli</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis as $key => $item)
                                    <tr>
                                        <td>{{ $rekamMedis->firstItem() + $key }}</td>
                                        <td>{{ $item->pasien->nama }}</td>
                                        <td>{{ $item->pasien->no_rm }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->tanggal_periksa)) }}</td>
                                        <td>{{ $item->dokter->nama }}</td>
                                        <td>{{ $item->poli->nama }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.rekam-medis.show', $item->id) }}"
                                                    class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <!-- <a href="{{ route('admin.rekam-medis.qrcode', $item->id) }}"
                                                    class="btn btn-sm btn-secondary" title="QR Code">
                                                    <i class="fas fa-qrcode"></i>
                                                </a> -->
                                                <a href="{{ route('admin.rekam-medis.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('admin.rekam-medis.destroy', $item->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data rekam medis</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $rekamMedis->links() }}
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
                    text: "Data rekam medis akan dihapus! Semua file pendukung yang terkait juga akan dihapus.",
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
