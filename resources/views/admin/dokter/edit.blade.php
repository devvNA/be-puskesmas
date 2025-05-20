@extends('layouts.admin')

@section('title', 'Edit Dokter')
@section('page-title', 'Edit Dokter')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Dokter</h5>
                    <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="poli_id" class="form-label">Poli <span class="text-danger">*</span></label>
                            <select name="poli_id" id="poli_id" class="form-select @error('poli_id') is-invalid @enderror"
                                required>
                                <option value="" disabled>-- Pilih Poli --</option>
                                @foreach ($poli as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('poli_id', $dokter->poli_id) == $p->id ? 'selected' : '' }}>
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

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $dokter->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="spesialisasi" class="form-label">Spesialisasi <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="spesialisasi" id="spesialisasi"
                                class="form-control @error('spesialisasi') is-invalid @enderror"
                                value="{{ old('spesialisasi', $dokter->spesialisasi) }}" required>
                            @error('spesialisasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control @error('foto') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengubah
                                foto.</small>

                            @if ($dokter->foto)
                                <div class="mt-2">
                                    <label>Foto Saat Ini:</label>
                                    <img src="{{ asset('storage/' . $dokter->foto) }}" alt="{{ $dokter->nama }}"
                                        class="img-thumbnail mt-1" style="height: 200px;">
                                </div>
                            @endif

                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                required>
                                <option value="aktif" {{ old('status', $dokter->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="cuti" {{ old('status', $dokter->status) == 'cuti' ? 'selected' : '' }}>
                                    Cuti</option>
                                <option value="off" {{ old('status', $dokter->status) == 'off' ? 'selected' : '' }}>Off
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i> Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // Preview gambar saat upload
            document.getElementById('foto').addEventListener('change', function(e) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    // Hapus preview lama
                    const oldPreview = document.querySelector('#new-preview');
                    if (oldPreview) {
                        oldPreview.remove();
                    }

                    // Buat preview baru
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.id = 'new-preview';
                    img.classList.add('img-thumbnail', 'mt-2');
                    img.style.height = '200px';

                    const container = document.createElement('div');
                    container.classList.add('mt-2');
                    container.innerHTML = '<label>Foto Baru:</label>';
                    container.appendChild(img);

                    // Tampilkan preview
                    const inputContainer = document.querySelector('#foto').parentElement;
                    const existingPreview = inputContainer.querySelector('div');

                    if (existingPreview) {
                        inputContainer.insertBefore(container, existingPreview);
                    } else {
                        inputContainer.appendChild(container);
                    }
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        </script>
    @endpush
@endsection
