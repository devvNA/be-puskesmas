@extends('layouts.admin')

@section('title', 'Tambah Jadwal Dokter ' . $dokter->nama)
@section('page-title', 'Tambah Jadwal Dokter ' . $dokter->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Jadwal Dokter {{ $dokter->nama }}</h5>
                    <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.dokter.jadwal.store', $dokter->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                            <select name="hari" id="hari" class="form-select @error('hari') is-invalid @enderror"
                                required>
                                <option value="" selected disabled>-- Pilih Hari --</option>
                                <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
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
                                        value="{{ old('jam_mulai') }}" required>
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
                                        value="{{ old('jam_selesai') }}" required>
                                    @error('jam_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif" {{ old('status') == 'tidak aktif' ? 'selected' : '' }}>
                                    Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
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
        });
    </script>
@endpush
