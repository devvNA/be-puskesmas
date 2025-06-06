@extends('layouts.admin')

@section('title', 'Edit Jadwal Poli ' . $poli->nama)
@section('page-title', 'Edit Jadwal Poli ' . $poli->nama)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Jadwal Poli {{ $poli->nama }}</h5>
                    <a href="{{ route('admin.jadwal.index', $poli->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.jadwal.update', [$poli->id, $jadwal->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                            <select name="hari" id="hari" class="form-select @error('hari') is-invalid @enderror"
                                required>
                                <option value="" disabled>-- Pilih Hari --</option>
                                <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin
                                </option>
                                <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa
                                </option>
                                <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu
                                </option>
                                <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis
                                </option>
                                <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat
                                </option>
                                <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu
                                </option>
                                <option value="Minggu" {{ old('hari', $jadwal->hari) == 'Minggu' ? 'selected' : '' }}>Minggu
                                </option>
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
                                    <label for="jam_buka" class="form-label">Jam Buka <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="jam_buka" id="jam_buka"
                                        class="form-control @error('jam_buka') is-invalid @enderror"
                                        value="{{ old('jam_buka', date('H:i', strtotime($jadwal->jam_buka))) }}" required>
                                    @error('jam_buka')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_tutup" class="form-label">Jam Tutup <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="jam_tutup" id="jam_tutup"
                                        class="form-control @error('jam_tutup') is-invalid @enderror"
                                        value="{{ old('jam_tutup', date('H:i', strtotime($jadwal->jam_tutup))) }}"
                                        required>
                                    @error('jam_tutup')
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
                                <option value="aktif" {{ old('status', $jadwal->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="tidak aktif"
                                    {{ old('status', $jadwal->status) == 'tidak aktif' ? 'selected' : '' }}>
                                    Tidak Aktif</option>
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
@endsection
