@extends('layouts.admin')

@section('title', 'Edit Data Pasien')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-sm btn-light rounded-circle me-3 shadow-sm border">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Data Pasien</h1>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
        <div class="card-header py-3 d-flex align-items-center" style="background-color: #11894A;">
            <h6 class="m-0 fw-bold text-white">
                <i class="fas fa-user-edit me-2"></i> Form Edit Pasien
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Informasi Utama -->
                    <div class="col-12">
                        <div class="p-3 border bg-light rounded-3 mb-2">
                            <h6 class="fw-bold mb-3">Informasi Utama</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="no_rm" class="form-label">Nomor Rekam Medis</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-file-medical text-primary"></i></span>
                                        <input type="text" class="form-control @error('no_rm') is-invalid @enderror"
                                            id="no_rm" name="no_rm" value="{{ old('no_rm', $pasien->no_rm) }}"
                                            placeholder="RM-XXX" readonly>
                                        @error('no_rm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Nomor rekam medis tidak dapat diubah</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-id-card text-primary"></i></span>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" value="{{ old('nik', $pasien->nik) }}" required maxlength="16"
                                            placeholder="16 digit NIK">
                                        @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $pasien->nama) }}" required
                                            placeholder="Masukkan nama lengkap">
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $pasien->email) }}"
                                            placeholder="contoh@email.com">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-phone text-primary"></i></span>
                                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                            id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pasien->no_telepon) }}"
                                            placeholder="contoh: 081234567890">
                                        @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pribadi -->
                    <div class="col-md-8">
                        <div class="p-3 border bg-light rounded-3 h-100">
                            <h6 class="fw-bold mb-3">Informasi Pribadi</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-primary"></i></span>
                                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                            id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}" required>
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-venus-mars text-primary"></i></span>
                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                            id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                                Laki-laki
                                            </option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan
                                            </option>
                                        </select>
                                        @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-tint text-danger"></i></span>
                                        <select class="form-select @error('golongan_darah') is-invalid @enderror"
                                            id="golongan_darah" name="golongan_darah">
                                            <option value="-" {{ old('golongan_darah', $pasien->golongan_darah) == '-' ? 'selected' : '' }}>Tidak diketahui</option>
                                            <option value="A" {{ old('golongan_darah', $pasien->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('golongan_darah', $pasien->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ old('golongan_darah', $pasien->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ old('golongan_darah', $pasien->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                        @error('golongan_darah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="hubungan_keluarga" class="form-label">Hubungan Keluarga</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-users text-primary"></i></span>
                                        <input type="text" class="form-control @error('hubungan_keluarga') is-invalid @enderror"
                                            id="hubungan_keluarga" name="hubungan_keluarga" value="{{ old('hubungan_keluarga', $pasien->hubungan_keluarga) }}"
                                            placeholder="Contoh: Kepala Keluarga">
                                        @error('hubungan_keluarga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt text-primary"></i></span>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                            id="alamat" name="alamat" rows="3" required
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat', $pasien->alamat) }}</textarea>
                                        @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="rt" class="form-label">RT</label>
                                    <input type="text" class="form-control @error('rt') is-invalid @enderror"
                                        id="rt" name="rt" value="{{ old('rt', $pasien->rt) }}" placeholder="001">
                                    @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="rw" class="form-label">RW</label>
                                    <input type="text" class="form-control @error('rw') is-invalid @enderror"
                                        id="rw" name="rw" value="{{ old('rw', $pasien->rw) }}" placeholder="002">
                                    @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" class="form-control @error('provinsi') is-invalid @enderror"
                                        id="provinsi" name="provinsi" value="{{ old('provinsi', $pasien->provinsi) }}"
                                        placeholder="Jawa Tengah">
                                    @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Pasien dan Informasi Tambahan -->
                    <div class="col-md-4">
                        <div class="p-3 border bg-light rounded-3 mb-4">
                            <h6 class="fw-bold mb-3">Foto Pasien</h6>

                            <div class="text-center py-3 mb-3 rounded bg-white">
                                @if($pasien->foto)
                                <div id="current-image" class="mb-3">
                                    <img src="{{ asset('storage/' . $pasien->foto) }}" alt="{{ $pasien->nama }}"
                                        class="img-thumbnail mx-auto" style="max-height: 200px; max-width: 100%;">
                                </div>
                                @endif

                                <div id="image-preview-container" class="mb-3" style="display: none;">
                                    <img id="image-preview" src="#" alt="Preview Foto"
                                        class="img-thumbnail mx-auto" style="max-height: 200px; max-width: 100%;">
                                </div>

                                <div id="default-preview" class="mb-3" style="{{ $pasien->foto ? 'display: none;' : '' }}">
                                    <div class="avatar-placeholder bg-secondary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x text-secondary opacity-50"></i>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <label for="foto" class="btn btn-outline-primary">
                                        <i class="fas fa-camera me-2"></i> Ubah Foto
                                    </label>
                                    <input type="file" class="form-control d-none @error('foto') is-invalid @enderror"
                                        id="foto" name="foto" accept="image/*">
                                </div>
                                @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2">Format: JPG, JPEG, atau PNG (maks. 2MB)</div>
                            </div>
                        </div>

                        <!-- Informasi BPJS & Jenis Pasien -->
                        <div class="p-3 border bg-light rounded-3">
                            <h6 class="fw-bold mb-3">Informasi Tambahan</h6>

                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Pasien <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis') is-invalid @enderror"
                                    id="jenis" name="jenis" required>
                                    <option value="" disabled>-- Pilih Jenis Pasien --</option>
                                    <option value="Reguler (BPJS)" {{ old('jenis', $pasien->jenis) == 'Reguler (BPJS)' ? 'selected' : '' }}>
                                        Reguler (BPJS)
                                    </option>
                                    <option value="Eksekutif (Non BPJS)" {{ old('jenis', $pasien->jenis) == 'Eksekutif (Non BPJS)' ? 'selected' : '' }}>
                                        Eksekutif (Non BPJS)
                                    </option>
                                </select>
                                @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_bpjs" class="form-label">No. BPJS</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-id-card-alt text-primary"></i></span>
                                    <input type="text" class="form-control @error('no_bpjs') is-invalid @enderror"
                                        id="no_bpjs" name="no_bpjs" value="{{ old('no_bpjs', $pasien->no_bpjs) }}"
                                        placeholder="Nomor Kartu BPJS">
                                    @error('no_bpjs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Kosongkan jika tidak memiliki kartu BPJS</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.pasien.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-success px-5" style="background-color: #11894A; border: none;">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview foto yang akan diupload
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('foto');
        const imagePreview = document.getElementById('image-preview');
        const imageContainer = document.getElementById('image-preview-container');
        const defaultPreview = document.getElementById('default-preview');
        const currentImage = document.getElementById('current-image');

        fileInput.addEventListener('change', function() {
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imageContainer.style.display = 'block';
                    defaultPreview.style.display = 'none';

                    // Jika ada foto lama, sembunyikan
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }

                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    });
</script>
@endpush
@endsection