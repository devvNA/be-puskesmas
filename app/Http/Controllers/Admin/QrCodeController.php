<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class QrCodeController extends Controller
{
    /**
     * Generate QR Code untuk pendaftaran
     *
     * @param Pendaftaran $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function generate(Pendaftaran $pendaftaran)
    {
        $qrData = [
            'pendaftaran_id' => $pendaftaran->id,
            'pasien' => [
                'id' => $pendaftaran->pasien_id,
                'nama' => $pendaftaran->pasien->nama,
                'no_rm' => $pendaftaran->pasien->no_rm
            ],
            'tanggal' => $pendaftaran->tanggal_pendaftaran,
            'no_antrian' => $pendaftaran->no_antrian,
            'url' => route('admin.pendaftaran.show', $pendaftaran->id)
        ];

        $qrCode = QrCode::format('png')->size(200)->generate(json_encode($qrData));

        return response($qrCode)->header('Content-Type', 'image/png');
    }

    /**
     * Generate QR Code untuk pendaftaran dalam format gambar
     *
     * @param Pendaftaran $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function generateImage(Pendaftaran $pendaftaran)
    {
        $qrData = [
            'pendaftaran_id' => $pendaftaran->id,
            'url' => route('admin.pendaftaran.show', $pendaftaran->id)
        ];

        $qrCode = QrCode::format('png')->size(200)->generate(json_encode($qrData));

        return response($qrCode)->header('Content-Type', 'image/png');
    }

    /**
     * Simpan QR Code ke file dan download
     *
     * @param Pendaftaran $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function saveQrCode(Pendaftaran $pendaftaran)
    {
        $qrValue = route('admin.pendaftaran.show', $pendaftaran->id);
        $qrCode = QrCode::format('png')->size(300)->generate($qrValue);

        $fileName = 'pendaftaran_' . $pendaftaran->id . '_qrcode.png';
        $path = 'qrcodes/' . $fileName;

        Storage::disk('public')->put($path, $qrCode);

        return Response::download(storage_path('app/public/' . $path), $fileName, [
            'Content-Type' => 'image/png',
        ]);
    }

    /**
     * Generate QR Code untuk rekam medis
     *
     * @param RekamMedis $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function generateRekamMedis(RekamMedis $rekamMedis)
    {
        $qrData = [
            'rekam_medis_id' => $rekamMedis->id,
            'url' => route('admin.rekam-medis.show', $rekamMedis->id)
        ];

        $qrCode = QrCode::size(200)->generate(json_encode($qrData));

        return view('admin.rekam_medis.qrcode', [
            'rekamMedis' => $rekamMedis,
            'qrCode' => $qrCode
        ]);
    }

    /**
     * Simpan QR Code rekam medis ke file dan download
     *
     * @param RekamMedis $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function saveRekamMedisQrCode(RekamMedis $rekamMedis)
    {
        $qrData = [
            'rekam_medis_id' => $rekamMedis->id,
            'url' => route('admin.rekam-medis.show', $rekamMedis->id)
        ];

        $qrCode = QrCode::format('png')->size(300)->generate(json_encode($qrData));

        $fileName = 'rekam_medis_' . $rekamMedis->id . '_qrcode.png';
        $path = 'qrcodes/' . $fileName;

        Storage::disk('public')->put($path, $qrCode);

        return Response::download(storage_path('app/public/' . $path), $fileName, [
            'Content-Type' => 'image/png',
        ]);
    }
}
