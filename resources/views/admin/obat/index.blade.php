@extends('layouts.admin')

@section('title', 'Manajemen Obat')
@section('page-title', 'Manajemen Obat')

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end align-items-center">
            <a href="{{ route('admin.obat.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Tambah Obat
            </a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari obat..." id="searchInput">
                <button class="btn btn-outline-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-2 ms-auto">
            <select class="form-select" id="filterKategori">
                <option value="">Semua Kategori</option>
                <!-- Opsi kategori bisa ditambahkan disini -->
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Daftar Obat</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="10%">Kode Obat</th>
                                    <th width="20%">Nama Obat</th>
                                    <th width="15%">Kategori</th>
                                    <th width="10%">Stok</th>
                                    <th width="10%">Satuan</th>
                                    <th width="15%">Harga</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($obat as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->kode_obat }}</td>
                                        <td>{{ $item->nama_obat }}</td>
                                        <td>{{ $item->kategori ?? '-' }}</td>
                                        <td class="text-center">
                                            @if (isset($item->stok) && $item->stok <= 10)
                                                <span class="badge bg-danger">{{ $item->stok ?? 0 }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $item->stok ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->satuan ?? '-' }}</td>
                                        <td class="text-end">Rp
                                            {{ isset($item->harga) ? number_format($item->harga, 0, ',', '.') : '0' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.obat.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning me-1" style="border-radius: 4px;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.obat.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-3">Tidak ada data obat</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <p class="mb-0">Menampilkan {{ $obat->firstItem() ?? 0 }} sampai
                                {{ $obat->lastItem() ?? 0 }} dari {{ $obat->total() ?? 0 }} data</p>
                        </div>
                        @if (isset($obat) && method_exists($obat, 'links'))
                            <nav aria-label="Page navigation">
                                {{ $obat->links('pagination::bootstrap-4') }}
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Fungsi pencarian
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Filter kategori
            $("#filterKategori").on("change", function() {
                var value = $(this).val().toLowerCase();
                if (value === "") {
                    $("table tbody tr").show();
                } else {
                    $("table tbody tr").filter(function() {
                        return $(this).children("td:eq(3)").text().toLowerCase().indexOf(value) > -
                            1;
                    }).show();
                    $("table tbody tr").filter(function() {
                        return $(this).children("td:eq(3)").text().toLowerCase().indexOf(value) ===
                            -1;
                    }).hide();
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item .page-link {
            border-radius: 0.25rem;
            margin: 0 2px;
            color: #11894A;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            color: #fff;
            background-color: #11894A;
            border-color: #11894A;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .btn-group .btn {
            border-radius: 0.25rem !important;
            margin: 0 2px;
        }

        .badge {
            font-size: 90%;
        }

        .btn-outline-primary {
            color: #11894A;
            border-color: #11894A;
        }

        .btn-outline-primary:hover {
            background-color: #11894A;
            border-color: #11894A;
        }

        .btn-primary {
            background-color: #11894A;
            border-color: #11894A;
        }

        .btn-primary:hover {
            background-color: #0a7a3e;
            border-color: #0a7a3e;
        }
    </style>
@endpush
