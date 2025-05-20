<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode OTP Puskesmas Kluwung</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #38b2ac;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 0 0 5px 5px;
            border: 1px solid #e2e8f0;
            border-top: none;
        }

        .otp-code {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 5px;
            margin: 20px 0;
            padding: 10px;
            background-color: #edf2f7;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Puskesmas Kluwung</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $userName }}</strong>,</p>

            <p>Berikut adalah kode OTP Anda untuk {{ $otpType === 'login' ? 'login' : ($otpType === 'register' ? 'pendaftaran' : 'reset password') }} di aplikasi Puskesmas Kluwung:</p>

            <div class="otp-code">{{ $otp }}</div>

            <p>Kode OTP ini akan kedaluwarsa dalam {{ $expiresIn }} menit.</p>

            <p><strong>PENTING:</strong> Jangan berikan kode ini kepada siapapun termasuk pihak yang mengaku sebagai Puskesmas Kluwung.</p>

            <p>Jika Anda tidak meminta kode ini, silakan abaikan email ini.</p>

            <p>Terima kasih,<br>Tim Puskesmas Kluwung</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Puskesmas Kluwung. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>