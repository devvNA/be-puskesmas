@extends('layouts.admin')

@section('title', 'Edit Jadwal ' . $dokter->nama)
@section('page-title', 'Edit Jadwal ' . $dokter->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #11894A; color: white;">
                    <h5 class="mb-0">Edit Jadwal Praktik Dokter {{ $dokter->nama }}</h5>
                    <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Informasi Jadwal</h5>
                                <p class="mb-0">Anda sedang mengedit jadwal hari <strong>{{ $jadwal->hari }}</strong> untuk dokter <strong>{{ $dokter->nama }}</strong></p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.dokter.jadwal.update', [$dokter->id, $jadwal->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                            <select name="hari" id="hari" class="form-select @error('hari') is-invalid @enderror"
                                required>
                                <option value="" disabled>-- Pilih Hari --</option>
                                <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                <option value="Minggu" {{ old('hari', $jadwal->hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                            </select>
                            @error('hari')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_mulai" class="form-label">Jam Mulai <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" id="jam_mulai"
                                        class="form-control @error('jam_mulai') is-invalid @enderror"
                                        value="{{ old('jam_mulai', date('H:i', strtotime($jadwal->jam_mulai))) }}" required>
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_selesai" class="form-label">Jam Selesai <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="jam_selesai" id="jam_selesai"
                                        class="form-control @error('jam_selesai') is-invalid @enderror"
                                        value="{{ old('jam_selesai', date('H:i', strtotime($jadwal->jam_selesai))) }}" required>
                                    @error('jam_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-aktif" value="aktif" {{ old('status', $jadwal->status) == 'aktif' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status-aktif">
                                            <span class="badge bg-success">Aktif</span> - Jadwal ini akan ditampilkan
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-nonaktif" value="tidak aktif" {{ old('status', $jadwal->status) == 'tidak aktif' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status-nonaktif">
                                            <span class="badge bg-danger">Tidak Aktif</span> - Jadwal ini tidak akan ditampilkan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success" style="background-color: #11894A; border-color: #11894A;">
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
            // Validasi jam selesai harus lebih dari jam mulai
            const jamMulai = document.getElementById('jam_mulai');
            const jamSelesai = document.getElementById('jam_selesai');

            jamSelesai.addEventListener('change', function() {
                if (jamMulai.value && jamSelesai.value && jamSelesai.value <= jamMulai.value) {
                    alert('Jam selesai harus lebih besar dari jam mulai');
                    jamSelesai.value = '';
                }
            });

            jamMulai.addEventListener('change', function() {
                if (jamMulai.value && jamSelesai.value && jamSelesai.value <= jamMulai.value) {
                    alert('Jam mulai harus lebih kecil dari jam selesai');
                    jamMulai.value = '';
                }
            });
        });
    </script>
@endpush
