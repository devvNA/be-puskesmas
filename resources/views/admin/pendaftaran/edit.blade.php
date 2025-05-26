@extends('layouts.admin')

@section('title', 'Edit Pendaftaran')
@section('page-title', 'Edit Pendaftaran')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Pendaftaran</h4>
                    <div>
                        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Informasi Pendaftaran</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>No. Antrian</strong></td>
                                            <td>: {{ $pendaftaran->no_antrian }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Pendaftaran</strong></td>
                                            <td>:
                                                {{ \Carbon\Carbon::parse($pendaftaran->tanggal_pendaftaran)->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status Kehadiran</strong></td>
                                            <td>:
                                                @if ($pendaftaran->status_kehadiran == 'sudah hadir')
                                                <span class="badge bg-success">Sudah Hadir</span>
                                                @if ($pendaftaran->waktu_hadir)
                                                <small class="text-muted d-block">
                                                    {{ \Carbon\Carbon::parse($pendaftaran->waktu_hadir)->format('d/m/Y H:i') }}
                                                </small>
                                                @endif
                                                @else
                                                <span class="badge bg-warning">Belum Hadir</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Informasi Pasien</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Nama Pasien</strong></td>
                                            <td>: {{ $pendaftaran->pasien->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>No. RM</strong></td>
                                            <td>: {{ $pendaftaran->pasien->no_rm }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIK</strong></td>
                                            <td>: {{ $pendaftaran->pasien->nik ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Lahir</strong></td>
                                            <td>:
                                                {{ \Carbon\Carbon::parse($pendaftaran->pasien->tanggal_lahir)->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat</strong></td>
                                            <td>: {{ $pendaftaran->pasien->alamat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kontak</strong></td>
                                            <td>: {{ $pendaftaran->pasien->no_telepon ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="pasien_id" class="col-md-3 col-form-label">Pasien <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="pasien_id" id="pasien_id"
                                    class="form-select @error('pasien_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pasien --</option>
                                    @foreach ($pasien as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('pasien_id', $pendaftaran->pasien_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->no_rm }} - {{ $p->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('pasien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="poli_id" class="col-md-3 col-form-label">Poli Tujuan <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="poli_id" id="poli_id"
                                    class="form-select @error('poli_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Poli --</option>
                                    @foreach ($poli as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('poli_id', $pendaftaran->poli_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('poli_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dokter_id" class="col-md-3 col-form-label">Dokter</label>
                            <div class="col-md-9">
                                <select name="dokter_id" id="dokter_id"
                                    class="form-select @error('dokter_id') is-invalid @enderror">
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach ($dokter as $d)
                                    <option value="{{ $d->id }}" data-poli="{{ $d->poli_id }}"
                                        {{ old('dokter_id', $pendaftaran->dokter_id) == $d->id ? 'selected' : '' }}>
                                        {{ $d->nama }} - {{ $d->spesialisasi }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('dokter_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_pendaftaran" class="col-md-3 col-form-label">Tanggal Pendaftaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_pendaftaran" id="tanggal_pendaftaran"
                                    class="form-control @error('tanggal_pendaftaran') is-invalid @enderror"
                                    value="{{ old('tanggal_pendaftaran', $pendaftaran->tanggal_pendaftaran) }}"
                                    required>
                                @error('tanggal_pendaftaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status_kehadiran" class="col-md-3 col-form-label">Status Kehadiran <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="status_kehadiran" id="status_kehadiran"
                                    class="form-select @error('status_kehadiran') is-invalid @enderror" required>
                                    <option value="belum hadir"
                                        {{ old('status_kehadiran', $pendaftaran->status_kehadiran) == 'belum hadir' ? 'selected' : '' }}>
                                        Belum Hadir</option>
                                    <option value="sudah hadir"
                                        {{ old('status_kehadiran', $pendaftaran->status_kehadiran) == 'sudah hadir' ? 'selected' : '' }}>
                                        Sudah Hadir</option>
                                </select>
                                @error('status_kehadiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="waktu_hadir" class="col-md-3 col-form-label">Waktu Hadir</label>
                            <div class="col-md-9">
                                <input type="datetime-local" name="waktu_hadir" id="waktu_hadir"
                                    class="form-control @error('waktu_hadir') is-invalid @enderror"
                                    value="{{ old('waktu_hadir', $pendaftaran->waktu_hadir ? \Carbon\Carbon::parse($pendaftaran->waktu_hadir)->format('Y-m-d\TH:i') : '') }}">
                                @error('waktu_hadir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Waktu pasien hadir di puskesmas (jika sudah hadir)</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="waktu_dipanggil" class="col-md-3 col-form-label">Estimasi Waktu Dipanggil</label>
                            <div class="col-md-9">
                                <input type="time" name="waktu_dipanggil" id="waktu_dipanggil"
                                    class="form-control @error('waktu_dipanggil') is-invalid @enderror"
                                    value="{{ old('waktu_dipanggil', $pendaftaran->waktu_dipanggil ? \Carbon\Carbon::parse($pendaftaran->waktu_dipanggil)->format('H:i') : '') }}">
                                @error('waktu_dipanggil')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Waktu perkiraan pasien akan dipanggil (format: HH:MM)</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="keterangan" class="col-md-3 col-form-label">Keterangan</label>
                            <div class="col-md-9">
                                <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                    rows="3">{{ old('keterangan', $pendaftaran->keterangan) }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.pendaftaran.index') }}"
                                    class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding-top: 5px;
            border-color: #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 37px;
        }
    </style>
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2
            $('#pasien_id, #poli_id, #dokter_id, #status_kehadiran').select2({
                placeholder: 'Pilih...',
                allowClear: true
            });

            // Filter dokter berdasarkan poli
            $('#poli_id').on('change', function() {
                const poliId = $(this).val();
                const dokterSelect = $('#dokter_id');

                // Reset dokter selection
                dokterSelect.val('').trigger('change');

                // Show/hide dokter based on selected poli
                if (poliId) {
                    dokterSelect.find('option').each(function() {
                        const dokterPoliId = $(this).data('poli');
                        if (dokterPoliId == poliId || !dokterPoliId) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                } else {
                    dokterSelect.find('option').show();
                }
            });

            // Toggle waktu_hadir field visibility based on status
            $('#status_kehadiran').on('change', function() {
                const status = $(this).val();
                if (status === 'sudah hadir') {
                    $('#waktu_hadir').closest('.row').removeClass('d-none');
                    if (!$('#waktu_hadir').val()) {
                        // Set default to current date and time if empty
                        const now = new Date();
                        const formattedDate = now.toISOString().slice(0, 16);
                        $('#waktu_hadir').val(formattedDate);
                    }
                } else {
                    $('#waktu_hadir').closest('.row').addClass('d-none');
                }
            }).trigger('change');

            // Trigger poli change on page load to apply existing filter
            $('#poli_id').trigger('change');
        });
    </script>
    @endpush