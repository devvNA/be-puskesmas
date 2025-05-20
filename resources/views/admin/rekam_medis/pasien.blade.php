@extends('layouts.admin')

@section('title', 'Riwayat Rekam Medis - ' . $pasien->nama)
@section('page-title', 'Riwayat Rekam Medis - ' . $pasien->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Rekam Medis Pasien</h5>
                    <div>
                        <a href="{{ route('admin.rekam-medis.create') }}?pasien_id={{ $pasien->id }}"
                            class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Rekam Medis Baru
                        </a>
                        <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header" style="background-color: #18b469; color: white;">
                                    <h6 class="mb-0">Data Pasien</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="30%">Nama Pasien</th>
                                            <td width="70%">: {{ $pasien->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Rekam Medis</th>
                                            <td>: {{ $pasien->no_rm }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>: {{ $pasien->nik ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>: {{ date('d/m/Y', strtotime($pasien->tanggal_lahir)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>: {{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: {{ $pasien->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon</th>
                                            <td>: {{ $pasien->no_telepon ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                @forelse($rekamMedis as $key => $item)
                                    <tr>
                                        <td>{{ $rekamMedis->firstItem() + $key }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->tanggal_periksa)) }}</td>
                                        <td>{{ $item->dokter->nama }}</td>
                                        <td>{{ $item->poli->nama }}</td>
                                        <td>{{ $item->diagnosis ?? 'Belum ada diagnosis' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.rekam-medis.show', $item->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.rekam-medis.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">
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
                                        <td colspan="6" class="text-center">Pasien ini belum memiliki riwayat rekam medis
                                        </td>
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
