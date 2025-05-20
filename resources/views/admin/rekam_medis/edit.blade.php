@extends('layouts.admin')

@section('title', 'Edit Rekam Medis')
@section('page-title', 'Edit Rekam Medis')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Rekam Medis</h5>
                    <div>
                        <a href="{{ route('admin.rekam-medis.show', $rekamMedis->id) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </a>
                        <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.rekam-medis.update', $rekamMedis->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pasien_id" class="form-label">Pasien <span
                                            class="text-danger">*</span></label>
                                    <select name="pasien_id" id="pasien_id"
                                        class="form-select @error('pasien_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- Pilih Pasien --</option>
                                        @foreach ($pasien as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('pasien_id', $rekamMedis->pasien_id) == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama }} ({{ $p->no_rm }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pasien_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pendaftaran_id" class="form-label">No. Pendaftaran</label>
                                    <select name="pendaftaran_id" id="pendaftaran_id"
                                        class="form-select @error('pendaftaran_id') is-invalid @enderror">
                                        <option value="">-- Tidak Ada Pendaftaran --</option>
                                        @foreach ($pendaftaran as $p)
                                            <option value="{{ $p->id }}" data-pasien-id="{{ $p->pasien_id }}"
                                                {{ old('pendaftaran_id', $rekamMedis->pendaftaran_id) == $p->id ? 'selected' : '' }}>
                                                {{ date('d/m/Y', strtotime($p->tanggal_pendaftaran)) }} - Antrian
                                                #{{ $p->no_antrian }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pendaftaran_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_periksa" class="form-label">Tanggal Periksa <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_periksa" id="tanggal_periksa"
                                        class="form-control @error('tanggal_periksa') is-invalid @enderror"
                                        value="{{ old('tanggal_periksa', $rekamMedis->tanggal_periksa instanceof \Carbon\Carbon ? $rekamMedis->tanggal_periksa->format('Y-m-d') : (is_string($rekamMedis->tanggal_periksa) ? date('Y-m-d', strtotime($rekamMedis->tanggal_periksa)) : '')) }}"
                                        required>
                                    @error('tanggal_periksa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dokter_id" class="form-label">Dokter <span
                                            class="text-danger">*</span></label>
                                    <select name="dokter_id" id="dokter_id"
                                        class="form-select @error('dokter_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- Pilih Dokter --</option>
                                        @foreach ($dokter as $d)
                                            <option value="{{ $d->id }}" data-poli="{{ $d->poli_id }}"
                                                {{ old('dokter_id', $rekamMedis->dokter_id) == $d->id ? 'selected' : '' }}>
                                                {{ $d->nama }} ({{ $d->spesialisasi }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dokter_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="poli_id" class="form-label">Poli <span class="text-danger">*</span></label>
                                    <select name="poli_id" id="poli_id"
                                        class="form-select @error('poli_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- Pilih Poli --</option>
                                        @foreach ($poli as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('poli_id', $rekamMedis->poli_id) == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('poli_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
                            <textarea name="keluhan" id="keluhan" rows="3" class="form-control @error('keluhan') is-invalid @enderror"
                                required>{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" class="form-control @error('diagnosis') is-invalid @enderror">{{ old('diagnosis', $rekamMedis->diagnosis) }}</textarea>
                            @error('diagnosis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tindakan" class="form-label">Tindakan</label>
                            <textarea name="tindakan" id="tindakan" rows="3" class="form-control @error('tindakan') is-invalid @enderror">{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
                            @error('tindakan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resep" class="form-label">Resep</label>
                            <textarea name="resep" id="resep" rows="3" class="form-control @error('resep') is-invalid @enderror">{{ old('resep', $rekamMedis->resep) }}</textarea>
                            @error('resep')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $rekamMedis->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">File Pendukung</label>

                            @if ($rekamMedis->filePendukung->count() > 0)
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">File yang sudah ada:</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Jenis</th>
                                                    <th>Nama File</th>
                                                    <th>Keterangan</th>
                                                    <th width="100">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rekamMedis->filePendukung as $file)
                                                    <tr>
                                                        <td>{{ ucfirst($file->jenis) }}</td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $file->path) }}"
                                                                target="_blank">
                                                                {{ basename($file->path) }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $file->keterangan ?? '-' }}</td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ asset('storage/' . $file->path) }}"
                                                                    class="btn btn-sm btn-info" target="_blank">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger btn-delete-file"
                                                                    data-id="{{ $file->id }}"
                                                                    data-name="{{ basename($file->path) }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" name="deleted_files" id="deleted-files" value="">
                            @endif

                            <h6 class="text-muted mb-2">Tambah file baru:</h6>
                            <div id="file-container">
                                <div class="file-input-row mb-3 d-flex gap-2 align-items-start">
                                    <select name="jenis_file[]"
                                        class="form-select @error('jenis_file.*') is-invalid @enderror"
                                        style="width: 200px;">
                                        <option value="lab">Hasil Lab</option>
                                        <option value="rujukan">Surat Rujukan</option>
                                        <option value="resep">Resep</option>
                                        <option value="foto">Foto</option>
                                        <option value="lain-lain">Lainnya</option>
                                    </select>
                                    <input type="file" name="file_pendukung[]"
                                        class="form-control @error('file_pendukung.*') is-invalid @enderror"
                                        style="flex: 1;">
                                    <input type="text" name="keterangan_file[]"
                                        class="form-control @error('keterangan_file.*') is-invalid @enderror"
                                        placeholder="Keterangan file..." style="flex: 1;">
                                    <button type="button" class="btn btn-danger btn-remove-file" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success" id="btn-add-file">
                                <i class="fas fa-plus me-1"></i> Tambah File
                            </button>
                            @if ($errors->has('file_pendukung.*'))
                                <div class="text-danger mt-1">
                                    Format file tidak valid atau ukuran file terlalu besar (max: 5MB).
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto select poli when dokter is selected
            const dokterSelect = document.getElementById('dokter_id');
            const poliSelect = document.getElementById('poli_id');

            dokterSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const poliId = selectedOption.getAttribute('data-poli');

                if (poliId) {
                    poliSelect.value = poliId;
                }
            });

            // Filter pendaftaran based on selected pasien
            const pasienSelect = document.getElementById('pasien_id');
            const pendaftaranSelect = document.getElementById('pendaftaran_id');
            const pendaftaranOptions = Array.from(pendaftaranSelect.options);

            pasienSelect.addEventListener('change', function() {
                const selectedPasienId = this.value;

                // Reset pendaftaran dropdown
                pendaftaranSelect.innerHTML = '<option value="">-- Tidak Ada Pendaftaran --</option>';

                // Filter pendaftaran options for this patient
                if (selectedPasienId) {
                    pendaftaranOptions.forEach(option => {
                        if (option.getAttribute('data-pasien-id') == selectedPasienId) {
                            pendaftaranSelect.appendChild(option.cloneNode(true));
                        }
                    });
                }
            });

            // Add and remove file inputs
            const fileContainer = document.getElementById('file-container');
            const btnAddFile = document.getElementById('btn-add-file');

            btnAddFile.addEventListener('click', function() {
                const fileRow = document.createElement('div');
                fileRow.className = 'file-input-row mb-3 d-flex gap-2 align-items-start';
                fileRow.innerHTML = `
                    <select name="jenis_file[]" class="form-select" style="width: 200px;">
                        <option value="lab">Hasil Lab</option>
                        <option value="rujukan">Surat Rujukan</option>
                        <option value="resep">Resep</option>
                        <option value="foto">Foto</option>
                        <option value="lain-lain">Lainnya</option>
                    </select>
                    <input type="file" name="file_pendukung[]" class="form-control" style="flex: 1;">
                    <input type="text" name="keterangan_file[]" class="form-control" placeholder="Keterangan file..." style="flex: 1;">
                    <button type="button" class="btn btn-danger btn-remove-file">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                fileContainer.appendChild(fileRow);

                // Enable first delete button if we have more than one row
                if (document.querySelectorAll('.file-input-row').length > 1) {
                    document.querySelector('.btn-remove-file').disabled = false;
                }

                // Add event listener to new delete button
                fileRow.querySelector('.btn-remove-file').addEventListener('click', function() {
                    fileRow.remove();

                    // Disable delete button if only one row remains
                    if (document.querySelectorAll('.file-input-row').length === 1) {
                        document.querySelector('.btn-remove-file').disabled = true;
                    }
                });
            });

            // Handle existing file deletion
            const deletedFiles = [];
            const deletedFilesInput = document.getElementById('deleted-files');

            document.querySelectorAll('.btn-delete-file').forEach(btn => {
                btn.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-id');
                    const fileName = this.getAttribute('data-name');

                    if (confirm(`Apakah Anda yakin ingin menghapus file "${fileName}"?`)) {
                        deletedFiles.push(fileId);
                        deletedFilesInput.value = JSON.stringify(deletedFiles);
                        this.closest('tr').remove();
                    }
                });
            });
        });
    </script>
@endpush
