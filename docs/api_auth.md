# Dokumentasi API Autentikasi - Puskesmas Kluwung

## Deskripsi

API Autentikasi Puskesmas Kluwung menyediakan endpoint untuk registrasi, login, dan verifikasi pengguna tanpa menggunakan password konvensional. Sistem ini menggunakan autentikasi berbasis OTP (One-Time Password) dan PIN untuk meningkatkan keamanan dan kemudahan penggunaan.

## Alur Autentikasi

### Pendaftaran (Register)

1. Pengguna melakukan pendaftaran dengan mengirimkan data profil (tanpa password)
2. Sistem menghasilkan OTP dan mengirimkannya ke email/nomor telepon pengguna
3. Pengguna memverifikasi OTP untuk menyelesaikan pendaftaran
4. Pengguna diminta membuat PIN untuk login di masa mendatang

### Login

Pengguna dapat login menggunakan salah satu dari dua metode:

**Metode 1: Login dengan PIN**
1. Pengguna memasukkan email/nomor telepon dan PIN 6 digit
2. Sistem memverifikasi dan memberikan token akses

**Metode 2: Login dengan OTP**
1. Pengguna memasukkan email/nomor telepon
2. Sistem mengirimkan OTP ke email/nomor telepon
3. Pengguna memasukkan OTP untuk login
4. Sistem memverifikasi dan memberikan token akses

## Endpoint

### 1. Registrasi Pengguna

**URL**: `/api/register`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| name      | string  | Ya    | Nama lengkap pengguna    |
| email     | string  | Salah satu harus ada | Email pengguna |
| no_telepon | string | Salah satu harus ada | Nomor telepon pengguna |
| nik       | string  | Ya    | Nomor Induk Kependudukan |
| tanggal_lahir | date | Ya | Tanggal lahir (format: YYYY-MM-DD) |
| jenis_kelamin | string | Ya | Gender (Laki-laki/Perempuan) |
| alamat    | string  | Ya    | Alamat lengkap           |

**Contoh Request**:

```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "nik": "1234567890123456",
  "tanggal_lahir": "1990-01-01",
  "jenis_kelamin": "Laki-laki",
  "alamat": "Jl. Contoh No. 123, Kluwung"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "Pendaftaran berhasil, silakan verifikasi dengan OTP",
  "user_id": 1,
  "contact": "budi@example.com",
  "requires_verification": true
}
```

**Status kode**:
- `201 Created`: Registrasi berhasil
- `422 Unprocessable Entity`: Validasi gagal

### 2. Verifikasi OTP setelah Registrasi

**URL**: `/api/verify-register-otp`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| user_id   | integer | Ya    | ID pengguna              |
| otp       | string  | Ya    | OTP 6 digit              |

**Contoh Request**:

```json
{
  "user_id": 1,
  "otp": "123456"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "Verifikasi OTP berhasil",
  "user": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "role": "pasien"
  },
  "token": "1|XAgB1sWyRRtIxMTsN8zsAOKV9dDgEb9DuZwJ4QFB",
  "has_pin": false,
  "next_step": "create_pin"
}
```

**Status kode**:
- `200 OK`: Verifikasi berhasil
- `400 Bad Request`: OTP tidak valid
- `422 Unprocessable Entity`: Validasi gagal
- `429 Too Many Requests`: Terlalu banyak percobaan

### 3. Login dengan OTP

**URL**: `/api/login-otp`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| identifier | string | Ya    | Email atau nomor telepon |

**Contoh Request**:

```json
{
  "identifier": "budi@example.com"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "OTP telah dikirim",
  "user_id": 1,
  "contact_method": "email",
  "contact": "budi@example.com",
  "has_pin": true
}
```

**Status kode**:
- `200 OK`: OTP berhasil dikirim
- `404 Not Found`: Pengguna tidak ditemukan
- `422 Unprocessable Entity`: Validasi gagal

### 4. Verifikasi OTP untuk Login

**URL**: `/api/verify-otp`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| user_id   | integer | Ya    | ID pengguna              |
| otp       | string  | Ya    | OTP 6 digit              |

**Contoh Request**:

```json
{
  "user_id": 1,
  "otp": "123456"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "Login berhasil",
  "user": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "role": "pasien"
  },
  "token": "1|XAgB1sWyRRtIxMTsN8zsAOKV9dDgEb9DuZwJ4QFB",
  "has_pin": true
}
```

**Status kode**:
- `200 OK`: Verifikasi berhasil
- `400 Bad Request`: OTP tidak valid
- `422 Unprocessable Entity`: Validasi gagal
- `429 Too Many Requests`: Terlalu banyak percobaan

### 5. Kirim Ulang OTP

**URL**: `/api/resend-otp`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| user_id   | integer | Ya    | ID pengguna              |

**Contoh Request**:

```json
{
  "user_id": 1
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "OTP baru telah dikirim",
  "contact": "budi@example.com"
}
```

**Status kode**:
- `200 OK`: OTP berhasil dikirim ulang
- `422 Unprocessable Entity`: Validasi gagal

### 6. Login dengan PIN

**URL**: `/api/login-pin`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| email     | string  | Salah satu harus ada | Email pengguna |
| no_telepon | string | Salah satu harus ada | Nomor telepon pengguna |
| pin       | string  | Ya    | PIN 6 digit              |

**Contoh Request**:

```json
{
  "email": "budi@example.com",
  "pin": "123456"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "Login dengan PIN berhasil",
  "user": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "role": "pasien"
  },
  "token": "1|XAgB1sWyRRtIxMTsN8zsAOKV9dDgEb9DuZwJ4QFB"
}
```

**Status kode**:
- `200 OK`: Login berhasil
- `400 Bad Request`: PIN belum dibuat
- `401 Unauthorized`: PIN tidak valid
- `404 Not Found`: Pengguna tidak ditemukan
- `422 Unprocessable Entity`: Validasi gagal
- `429 Too Many Requests`: Terlalu banyak percobaan

### 7. Verifikasi Email/Nomor Telepon

**URL**: `/api/verify-email`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| email     | string  | Salah satu harus ada | Email pengguna |
| no_telepon | string | Salah satu harus ada | Nomor telepon pengguna |

**Contoh Request**:

```json
{
  "email": "budi@example.com"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "Pengguna ditemukan",
  "user_id": 1,
  "name": "Budi Santoso",
  "has_pin": true,
  "auth_methods": {
    "pin": true,
    "otp": true
  }
}
```

**Status kode**:
- `200 OK`: Verifikasi berhasil
- `404 Not Found`: Pengguna tidak ditemukan
- `422 Unprocessable Entity`: Validasi gagal

### 8. Membuat/Mengubah PIN

**URL**: `/api/pin`

**Metode**: `POST` (buat baru) / `PUT` (update)

**Headers**:
- Authorization: Bearer {token}

**Parameter Request untuk membuat PIN**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| pin       | string  | Ya    | PIN 6 digit              |

**Parameter Request untuk mengubah PIN**:

| Parameter   | Tipe    | Wajib | Deskripsi                |
|-------------|---------|-------|--------------------------|
| current_pin | string  | Ya    | PIN saat ini             |
| new_pin     | string  | Ya    | PIN baru                 |

**Contoh Request untuk membuat PIN**:

```json
{
  "pin": "123456"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "PIN berhasil dibuat"
}
```

**Status kode**:
- `200 OK`: Operasi berhasil
- `400 Bad Request`: PIN belum dibuat (untuk update)
- `401 Unauthorized`: PIN saat ini tidak valid (untuk update)
- `422 Unprocessable Entity`: Validasi gagal

### 9. Verifikasi PIN

**URL**: `/api/pin/verify`

**Metode**: `POST`

**Headers**:
- Authorization: Bearer {token}

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| pin       | string  | Ya    | PIN 6 digit              |

**Contoh Request**:

```json
{
  "pin": "123456"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "PIN valid"
}
```

**Status kode**:
- `200 OK`: PIN valid
- `400 Bad Request`: PIN belum dibuat
- `401 Unauthorized`: PIN tidak valid
- `422 Unprocessable Entity`: Validasi gagal

### 10. Hapus PIN

**URL**: `/api/pin`

**Metode**: `DELETE`

**Headers**:
- Authorization: Bearer {token}

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| pin       | string  | Ya    | PIN saat ini             |

**Contoh Request**:

```json
{
  "pin": "123456"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "PIN berhasil dihapus"
}
```

**Status kode**:
- `200 OK`: Operasi berhasil
- `400 Bad Request`: PIN belum dibuat
- `401 Unauthorized`: PIN tidak valid
- `422 Unprocessable Entity`: Validasi gagal

## Keamanan API

1. **Rate Limiting**: Semua endpoint autentikasi dan verifikasi dilindungi dengan rate limiting untuk mencegah serangan brute force. Batas percobaan adalah 5 kali per menit per alamat IP.

2. **Enkripsi**: PIN dan OTP disimpan dalam bentuk yang dienkripsi. PIN tidak pernah dikirimkan dalam bentuk plain-text.

3. **Token Berbasis Waktu**: OTP valid hanya untuk periode waktu terbatas (15 menit).

4. **Autentikasi Token**: Semua endpoint yang memerlukan autentikasi dilindungi dengan Laravel Sanctum token authentication.

## Catatan Tambahan

- OTP selalu terdiri dari 6 digit angka
- PIN harus terdiri dari 6 digit angka
- Pembatasan percobaan login/verifikasi berlaku per alamat IP 
