@extends('layouts.admin')

@section('title', 'Detail Dokter - ' . $dokter->nama)
@section('page-title', 'Detail Dokter - ' . $dokter->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Dokter</h5>
                    <div>
                        <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if ($dokter->foto)
                                <img src="{{ asset('storage/' . $dokter->foto) }}" alt="{{ $dokter->nama }}"
                                    class="img-thumbnail mb-3" style="max-height: 250px;">
                            @else
                                <img src="https://via.placeholder.com/250x250?text=Foto+Dokter" alt="No Image"
                                    class="img-thumbnail mb-3">
                            @endif

                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.jadwal.index', $dokter->id) }}" class="btn btn-primary">
                                    <i class="fas fa-calendar-alt me-1"></i> Kelola Jadwal Praktik
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%" style="background-color: #f8f9fa;">Nama Dokter</th>
                                    <td width="70%">{{ $dokter->nama }}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa;">Spesialisasi</th>
                                    <td>{{ $dokter->spesialisasi }}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa;">Poli</th>
                                    <td>{{ $dokter->poli->nama }}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa;">Status</th>
                                    <td>
                                        @if ($dokter->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($dokter->status == 'cuti')
                                            <span class="badge bg-warning text-dark">Cuti</span>
                                        @else
                                            <span class="badge bg-danger">Off</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa;">Terakhir Diperbarui</th>
                                    <td>{{ $dokter->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #11894A; color: white;">
                                    <h5 class="mb-0">Jadwal Praktik</h5>
                                    <a href="{{ route('admin.dokter.jadwal.create', $dokter->id) }}"
                                        class="btn btn-sm btn-light">
                                        <i class="fas fa-plus-circle me-1"></i> Tambah Jadwal
                                    </a>
                                </div>
                                <div class="card-body">
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @if(session('info'))
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <i class="fas fa-info-circle me-1"></i> {{ session('info') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <!-- Informasi jadwal default -->
                                    @if($dokter->jadwal->where('status', 'tidak aktif')->count() == $dokter->jadwal->count())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Informasi:</strong> Semua jadwal dokter ini masih berstatus <strong>Tidak Aktif</strong>.
                                        Silahkan edit jadwal untuk mengaktifkan jadwal praktik dokter.
                                    </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead style="background-color: #E7E7E7; color: black;">
                                                <tr>
                                                    <th width="5%">No.</th>
                                                    <th width="20%">Hari</th>
                                                    <th width="20%">Jam Mulai</th>
                                                    <th width="20%">Jam Selesai</th>
                                                    <th width="15%">Status</th>
                                                    <th width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dokter->jadwal as $key => $jadwal)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $jadwal->hari }}</td>
                                                        <td>{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</td>
                                                        <td>{{ date('H:i', strtotime($jadwal->jam_selesai)) }}</td>
                                                        <td>
                                                            @if ($jadwal->status == 'aktif')
                                                                <span class="badge bg-success">Aktif</span>
                                                            @else
                                                                <span class="badge bg-danger">Tidak Aktif</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('admin.dokter.jadwal.edit', [$dokter->id, $jadwal->id]) }}"
                                                                    class="btn btn-sm btn-warning">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger btn-delete-jadwal"
                                                                    data-id="{{ $jadwal->id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>

                                                                <form id="delete-jadwal-form-{{ $jadwal->id }}"
                                                                    action="{{ route('admin.dokter.jadwal.destroy', [$dokter->id, $jadwal->id]) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Belum ada jadwal tersedia
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Informasi cara menggunakan jadwal -->
                                    <div class="mt-3">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title"><i class="fas fa-info-circle me-2"></i> Petunjuk Penggunaan Jadwal</h6>
                                                <ul class="mb-0 ps-3">
                                                    <li>Klik tombol <strong>Edit</strong> untuk mengubah jadwal praktik dokter</li>
                                                    <li>Ubah status jadwal menjadi <strong>Aktif</strong> agar jadwal ditampilkan</li>
                                                    <li>Jadwal yang tidak aktif tidak akan terlihat oleh pasien</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Delete confirmation untuk jadwal
        document.querySelectorAll('.btn-delete-jadwal').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Jadwal praktik dokter akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-jadwal-form-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush
