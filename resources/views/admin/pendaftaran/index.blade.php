    @extends('layouts.admin')

    @section('title', 'Manajemen Pendaftaran')
    @section('page-title', 'Manajemen Pendaftaran')

    @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pendaftaran
                        @if(isset($search) && !empty($search))
                        | Pencarian: "{{ $search }}"
                        @elseif(isset($tanggal) && !empty($tanggal))
                        | Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}
                        @else
                        Hari Ini
                        @endif
                    </h5>
                    <div class="d-flex">
                        <button type="button" class="btn btn-success me-2" style="background-color: #09448CFF" data-bs-toggle="modal" data-bs-target="#scanQRModal">
                            <i class="fas fa-qrcode me-1"></i> Scan QR
                        </button>
                        <a href="{{ route('admin.pendaftaran.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Pendaftaran
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6 class="mb-2">Pencarian berdasarkan Nama Pasien atau No. RM</h6>
                            <form action="{{ route('admin.pendaftaran.search-pasien') }}" method="GET">
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-search me-1"></i> Pencarian</span>
                                            <input type="text" name="search" class="form-control" placeholder="Masukkan Nama Pasien atau No. RM"
                                                value="{{ $search ?? '' }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary me-2">
                                                Cari
                                            </button>
                                            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary">
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if(isset($message))
                    <div class="alert alert-info">
                        {{ $message }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="8%">No. Antrian</th>
                                    <th width="18%">Nama Pasien</th>
                                    <th width="12%">No. Rekam Medis</th>
                                    <th width="12%">Poli</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Est. Panggil</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaran as $key => $item)
                                <tr>
                                    <td>{{ $pendaftaran->firstItem() + $key }}</td>
                                    <td>{{ $item->no_antrian }}</td>
                                    <td>{{ $item->pasien->nama }}</td>
                                    <td>{{ $item->pasien->no_rm }}</td>
                                    <td>{{ $item->poli->nama }}</td>
                                    <td>
                                        @if ($item->status_kehadiran == 'sudah hadir')
                                        <span class="badge bg-success">Sudah Hadir</span>
                                        @if ($item->waktu_hadir)
                                        <small class="d-block text-muted">
                                            {{ \Carbon\Carbon::parse($item->waktu_hadir)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                        </small>
                                        @endif
                                        @else
                                        <form action="{{ route('admin.pendaftaran.status', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="status_kehadiran" value="sudah hadir">
                                            <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                                <i class="fas fa-check-circle me-1"></i> Tandai Hadir
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->waktu_dipanggil)
                                        {{ \Carbon\Carbon::parse($item->waktu_dipanggil)->format('H:i') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.pendaftaran.show', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pendaftaran.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('admin.pendaftaran.destroy', $item->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        @if(isset($search) && !empty($search))
                                        Tidak ditemukan data pendaftaran dengan kata kunci "{{ $search }}"
                                        @elseif(isset($tanggal) && !empty($tanggal))
                                        Tidak ada data pendaftaran pada tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}
                                        @else
                                        Tidak ada data pendaftaran hari ini
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Menampilkan {{ $pendaftaran->count() }} dari {{ $pendaftaran->total() }} data
                        </div>
                        <div>
                            {{ $pendaftaran->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Scan QR -->
    <div class="modal fade" id="scanQRModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan QR Code Kehadiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-reader" style="width: 100%"></div>
                    <div id="qr-reader-results" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('css')
    <style>
        .status-select {
            min-width: 120px;
        }
    </style>
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.0/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Delete confirmation
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data pendaftaran akan dihapus!",
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

        // QR Scanner setup
        document.addEventListener('DOMContentLoaded', function() {
            const html5QrCode = new Html5Qrcode("qr-reader");
            const qrResultContainer = document.getElementById('qr-reader-results');

            // Start QR scan when modal opens
            const scanQRModal = document.getElementById('scanQRModal');
            scanQRModal.addEventListener('shown.bs.modal', function() {
                const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                    try {
                        const data = JSON.parse(decodedText);

                        if (data.pendaftaran_id) {
                            // Stop scanning
                            html5QrCode.stop();

                            // Show loading message
                            qrResultContainer.innerHTML =
                                '<div class="alert alert-info">Memproses kehadiran...</div>';

                            // Process attendance
                            fetch("{{ route('admin.pendaftaran.scan-qr') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        pendaftaran_id: data.pendaftaran_id
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        qrResultContainer.innerHTML =
                                            '<div class="alert alert-success">Kehadiran berhasil dicatat</div>';

                                        // Reload page after 2 seconds
                                        setTimeout(() => {
                                            location.reload();
                                        }, 2000);
                                    } else {
                                        qrResultContainer.innerHTML =
                                            '<div class="alert alert-danger">Gagal mencatat kehadiran: ' + (data.message || 'Terjadi kesalahan') + '</div>';
                                    }
                                })
                                .catch(error => {
                                    qrResultContainer.innerHTML =
                                        '<div class="alert alert-danger">Terjadi kesalahan: ' +
                                        error.message + '</div>';
                                });
                        } else {
                            qrResultContainer.innerHTML =
                                '<div class="alert alert-danger">QR Code tidak valid</div>';
                        }
                    } catch (error) {
                        qrResultContainer.innerHTML =
                            '<div class="alert alert-danger">Format QR Code tidak valid</div>';
                    }
                };

                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeSuccessCallback,
                    (errorMessage) => {
                        // console.error(errorMessage);
                    }
                ).catch((err) => {
                    qrResultContainer.innerHTML =
                        '<div class="alert alert-danger">Kamera tidak tersedia atau izin ditolak</div>';
                });
            });

            // Stop QR scan when modal closes
            scanQRModal.addEventListener('hidden.bs.modal', function() {
                if (html5QrCode.isScanning) {
                    html5QrCode.stop();
                }
                qrResultContainer.innerHTML = '';
            });
        });
    </script>
    @endpush