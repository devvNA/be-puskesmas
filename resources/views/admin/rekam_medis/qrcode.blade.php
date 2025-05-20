@extends('layouts.admin')

@section('title', 'QR Code Rekam Medis')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">QR Code Rekam Medis</h5>
                        <div>
                            <a href="{{ route('admin.rekam-medis.show', $rekamMedis->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <h6>Detail Rekam Medis</h6>
                            <p class="mb-1">Pasien: <strong>{{ $rekamMedis->pasien->nama }}</strong></p>
                            <p class="mb-1">No. RM: <strong>{{ $rekamMedis->pasien->no_rm }}</strong></p>
                            <p class="mb-1">Tanggal Periksa:
                                <strong>{{ date('d/m/Y', strtotime($rekamMedis->tanggal_periksa)) }}</strong>
                            </p>
                            <p class="mb-1">Dokter: <strong>{{ $rekamMedis->dokter->nama }}</strong></p>
                            <p class="mb-0">Poli: <strong>{{ $rekamMedis->poli->nama }}</strong></p>
                        </div>

                        <div class="mb-4">
                            <div class="qr-code-container p-3 bg-white d-inline-block mb-3">
                                {!! $qrCode !!}
                            </div>
                            <p class="text-muted">Scan QR Code ini untuk melihat detail rekam medis</p>
                        </div>

                        <div>
                            <a href="{{ route('admin.rekam-medis.qrcode.download', $rekamMedis->id) }}"
                                class="btn btn-primary">
                                <i class="fas fa-download me-1"></i> Download QR Code
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
