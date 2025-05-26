@extends('layouts.admin')

@section('title', 'Tambah Pendaftaran')
@section('page-title', 'Tambah Pendaftaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Form Tambah Pendaftaran</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.pendaftaran.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <label for="pasien_id" class="col-md-3 col-form-label">Pasien <span
                                class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="pasien_id" id="pasien_id"
                                class="form-select @error('pasien_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach ($pasien as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('pasien_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->no_rm }} - {{ $p->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('pasien_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Pasien belum terdaftar? <a href="{{ route('admin.pasien.create') }}"
                                    target="_blank">Tambah Pasien Baru</a>
                            </div>
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
                                    {{ old('poli_id') == $p->id ? 'selected' : '' }}>
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
                                    {{ old('dokter_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->nama }} - {{ $d->spesialisasi }}
                                </option>
                                @endforeach
                            </select>
                            @error('dokter_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Dokter akan difilter berdasarkan poli yang dipilih</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tanggal_pendaftaran" class="col-md-3 col-form-label">Tanggal Pendaftaran <span
                                class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="date" name="tanggal_pendaftaran" id="tanggal_pendaftaran"
                                class="form-control @error('tanggal_pendaftaran') is-invalid @enderror"
                                value="{{ old('tanggal_pendaftaran', date('Y-m-d')) }}" required>
                            @error('tanggal_pendaftaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="waktu_dipanggil" class="col-md-3 col-form-label">Estimasi Waktu Dipanggil</label>
                        <div class="col-md-9">
                            <input type="time" name="waktu_dipanggil" id="waktu_dipanggil"
                                class="form-control @error('waktu_dipanggil') is-invalid @enderror"
                                value="{{ old('waktu_dipanggil') }}">
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
                                rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary ms-2">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('#pasien_id').select2({
            placeholder: 'Pilih Pasien',
            allowClear: true
        });

        $('#poli_id').select2({
            placeholder: 'Pilih Poli',
            allowClear: true
        });

        $('#dokter_id').select2({
            placeholder: 'Pilih Dokter',
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

        // Trigger poli change on page load to apply existing filter
        $('#poli_id').trigger('change');
    });
</script>
@endpush

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