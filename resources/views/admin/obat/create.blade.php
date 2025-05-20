@extends('layouts.admin')

@section('title', 'Tambah Obat Baru')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Tambah Obat Baru</h4>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.obat.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kode_obat" class="form-label">Kode Obat</label>
                                        <input type="text" class="form-control @error('kode_obat') is-invalid @enderror"
                                            id="kode_obat" name="kode_obat" value="{{ old('kode_obat') }}" required>
                                        @error('kode_obat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_obat" class="form-label">Nama Obat</label>
                                        <input type="text" class="form-control @error('nama_obat') is-invalid @enderror"
                                            id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}" required>
                                        @error('nama_obat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                            name="kategori" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <option value="Analgesik"
                                                {{ old('kategori') == 'Analgesik' ? 'selected' : '' }}>Analgesik</option>
                                            <option value="Antibiotik"
                                                {{ old('kategori') == 'Antibiotik' ? 'selected' : '' }}>Antibiotik</option>
                                            <option value="Vitamin" {{ old('kategori') == 'Vitamin' ? 'selected' : '' }}>
                                                Vitamin</option>
                                            <option value="Lambung" {{ old('kategori') == 'Lambung' ? 'selected' : '' }}>
                                                Lambung</option>
                                            <option value="Flu dan Batuk"
                                                {{ old('kategori') == 'Flu dan Batuk' ? 'selected' : '' }}>Flu dan Batuk
                                            </option>
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <select class="form-select @error('satuan') is-invalid @enderror" id="satuan"
                                            name="satuan" required>
                                            <option value="" selected disabled>Pilih Satuan</option>
                                            <option value="Tablet" {{ old('satuan') == 'Tablet' ? 'selected' : '' }}>Tablet
                                            </option>
                                            <option value="Kapsul" {{ old('satuan') == 'Kapsul' ? 'selected' : '' }}>Kapsul
                                            </option>
                                            <option value="Sirup" {{ old('satuan') == 'Sirup' ? 'selected' : '' }}>Sirup
                                            </option>
                                            <option value="Suspensi" {{ old('satuan') == 'Suspensi' ? 'selected' : '' }}>
                                                Suspensi</option>
                                            <option value="Salep" {{ old('satuan') == 'Salep' ? 'selected' : '' }}>Salep
                                            </option>
                                        </select>
                                        @error('satuan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                            id="stok" name="stok" value="{{ old('stok') }}" min="0"
                                            required>
                                        @error('stok')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga (Rp)</label>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                            id="harga" name="harga" value="{{ old('harga') }}" min="0"
                                            required>
                                        @error('harga')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
