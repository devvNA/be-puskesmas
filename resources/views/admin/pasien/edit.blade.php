@extends('layouts.admin')

@section('title', 'Edit Data Pasien')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Pasien</h1>
        <div>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #11894A; color: white;">
            <h6 class="m-0 font-weight-bold">Form Edit Pasien</h6>
            <span class="badge bg-light text-dark">RM: {{ $pasien->no_rm }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_rm" class="form-label">Nomor Rekam Medis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_rm') is-invalid @enderror"
                                id="no_rm" name="no_rm" value="{{ old('no_rm', $pasien->no_rm) }}" required>
                            @error('no_rm')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: RM-XXX (contoh: RM-001)</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                id="nik" name="nik" value="{{ old('nik', $pasien->nik) }}" required maxlength="16"
                                placeholder="16 digit NIK">
                            @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Masukkan 16 digit Nomor Induk Kependudukan</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                        id="nama" name="nama" value="{{ old('nama', $pasien->nama) }}" required>
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email', $pasien->email) }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}" required>
                            @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                        id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                    @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                            id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pasien->no_telepon) }}"
                            required placeholder="contoh: 081234567890">
                    </div>
                    @error('no_telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="foto" class="form-label">Foto Pasien</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                        id="foto" name="foto" accept="image/*">
                    @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Upload foto baru dengan format JPG, JPEG, atau PNG (maks. 2MB)</div>

                    <div class="mt-3 mb-2">
                        @if($pasien->foto)
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ asset('storage/' . $pasien->foto) }}" alt="Foto {{ $pasien->nama }}"
                                    class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            <div class="col">
                                <p class="text-muted mb-0 small">Foto saat ini</p>
                                <small class="text-muted">Kosongkan field foto jika tidak ingin mengubah foto</small>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i> Belum ada foto pasien
                        </div>
                        @endif
                    </div>

                    <div class="mt-2" id="image-preview-container" style="display: none;">
                        <p class="text-muted mb-1 small">Preview foto baru:</p>
                        <img id="image-preview" src="#" alt="Preview Foto" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success" style="background-color: #11894A; border-color: #11894A;">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview foto yang diupload
    document.getElementById('foto').addEventListener('change', function() {
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });

    // Form validation
    (function() {
        'use strict';

        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Validasi NIK hanya angka
    document.getElementById('nik').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush
@endsection
