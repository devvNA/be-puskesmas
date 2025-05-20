@extends('layouts.admin')

@section('title', 'Edit Poli')
@section('page-title', 'Edit')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Poli</h4>
                        <a href="{{ route('admin.poli.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.poli.update', $poli->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Poli <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama', $poli->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $poli->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kuota_harian" class="form-label">Kuota Harian <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('kuota_harian') is-invalid @enderror"
                                    id="kuota_harian" name="kuota_harian"
                                    value="{{ old('kuota_harian', $poli->kuota_harian) }}" min="0" required>
                                @error('kuota_harian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="aktif" {{ old('status', $poli->status) == 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="tidak aktif"
                                        {{ old('status', $poli->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-light me-md-2">Reset</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Script validasi tambahan
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const kuotaHarian = document.getElementById('kuota_harian');
                if (parseInt(kuotaHarian.value) < 0) {
                    event.preventDefault();
                    alert('Kuota harian tidak boleh kurang dari 0');
                }
            });

            // Reset form dengan nilai asli dari database, bukan nilai kosong
            const resetButton = document.querySelector('button[type="reset"]');
            resetButton.addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('nama').value = '{{ $poli->nama }}';
                document.getElementById('deskripsi').value = '{{ $poli->deskripsi }}';
                document.getElementById('kuota_harian').value = '{{ $poli->kuota_harian }}';
                document.getElementById('status').value = '{{ $poli->status }}';
            });
        });
    </script>
@endpush
