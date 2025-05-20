# Dokumentasi API PIN - Puskesmas Kluwung

## Deskripsi

API PIN digunakan untuk manajemen PIN sebagai metode autentikasi alternatif untuk pengguna aplikasi Puskesmas Kluwung. PIN terdiri dari 6 digit angka dan dapat digunakan untuk login ke aplikasi sebagai alternatif dari password.

## Endpoint Login dan Verifikasi

### 1. Verifikasi Email

Endpoint ini digunakan untuk memverifikasi email pengguna tanpa memerlukan password. Fungsi ini digunakan sebagai langkah awal dalam alur login.

**URL**: `/api/verify-email`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| email     | string  | Ya    | Email pengguna terdaftar |

**Contoh Request**:

```json
{
  "email": "pasien@example.com"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "Email ditemukan",
  "user_id": 1,
  "name": "Pasien Test",
  "has_pin": true,
  "auth_methods": {
    "pin": true,
    "password": true
  }
}
```

**Response Error**:

```json
{
  "success": false,
  "message": "Email tidak ditemukan"
}
```

Status kode:
- `200 OK`: Operasi berhasil
- `404 Not Found`: Email tidak ditemukan
- `422 Unprocessable Entity`: Validasi gagal

### 2. Login dengan PIN

Endpoint ini digunakan untuk melakukan login dengan kombinasi email dan PIN.

**URL**: `/api/login-pin`

**Metode**: `POST`

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi                |
|-----------|---------|-------|--------------------------|
| email     | string  | Ya    | Email pengguna terdaftar |
| pin       | string  | Ya    | PIN 6 digit angka        |

**Contoh Request**:

```json
{
  "email": "pasien@example.com",
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
    "name": "Pasien Test",
    "email": "pasien@example.com",
    "role": "pasien",
    "created_at": "2025-05-18T08:18:28.000000Z",
    "updated_at": "2025-05-18T08:18:28.000000Z"
  },
  "token": "1|XAgB1sWyRRtIxMTsN8zsAOKV9dDgEb9DuZwJ4QFB"
}
```

**Response Error**:

```json
{
  "success": false,
  "message": "PIN tidak valid"
}
```

Status kode:
- `200 OK`: Operasi berhasil
- `401 Unauthorized`: PIN tidak valid
- `400 Bad Request`: PIN belum dibuat untuk pengguna
- `404 Not Found`: Email tidak ditemukan
- `422 Unprocessable Entity`: Validasi gagal

## Endpoint Manajemen PIN

### 1. Membuat PIN Baru

Endpoint ini digunakan untuk membuat PIN baru untuk pengguna yang sudah login.

**URL**: `/api/pin`

**Metode**: `POST`

**Headers**:
- Authorization: Bearer {token}

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi              |
|-----------|---------|-------|------------------------|
| pin       | string  | Ya    | PIN 6 digit angka      |

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
  "message": "PIN berhasil dibuat"
}
```

**Response Error**:

```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "pin": ["PIN harus 6 digit angka"]
  }
}
```

### 2. Verifikasi PIN

Endpoint ini digunakan untuk memverifikasi PIN pengguna yang telah login.

**URL**: `/api/pin/verify`

**Metode**: `POST`

**Headers**:
- Authorization: Bearer {token}

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi         |
|-----------|---------|-------|--------------------|
| pin       | string  | Ya    | PIN 6 digit angka  |

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

**Response Error**:

```json
{
  "success": false,
  "message": "PIN tidak valid"
}
```

Status kode:
- `200 OK`: Operasi berhasil
- `401 Unauthorized`: PIN tidak valid
- `400 Bad Request`: PIN belum dibuat
- `422 Unprocessable Entity`: Validasi gagal

### 3. Mengubah PIN

Endpoint ini digunakan untuk mengubah PIN pengguna yang telah login.

**URL**: `/api/pin`

**Metode**: `PUT`

**Headers**:
- Authorization: Bearer {token}

**Parameter Request**:

| Parameter   | Tipe    | Wajib | Deskripsi           |
|-------------|---------|-------|--------------------|
| current_pin | string  | Ya    | PIN saat ini       |
| new_pin     | string  | Ya    | PIN baru 6 digit   |

**Contoh Request**:

```json
{
  "current_pin": "123456",
  "new_pin": "654321"
}
```

**Contoh Response Sukses**:

```json
{
  "success": true,
  "message": "PIN berhasil diubah"
}
```

**Response Error**:

```json
{
  "success": false,
  "message": "PIN saat ini tidak valid"
}
```

Status kode:
- `200 OK`: Operasi berhasil
- `401 Unauthorized`: PIN saat ini tidak valid
- `400 Bad Request`: PIN belum dibuat
- `422 Unprocessable Entity`: Validasi gagal

### 4. Menghapus PIN

Endpoint ini digunakan untuk menghapus PIN pengguna yang telah login.

**URL**: `/api/pin`

**Metode**: `DELETE`

**Headers**:
- Authorization: Bearer {token}

**Parameter Request**:

| Parameter | Tipe    | Wajib | Deskripsi         |
|-----------|---------|-------|--------------------|
| pin       | string  | Ya    | PIN saat ini       |

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

**Response Error**:

```json
{
  "success": false,
  "message": "PIN tidak valid"
}
```

Status kode:
- `200 OK`: Operasi berhasil
- `401 Unauthorized`: PIN tidak valid
- `400 Bad Request`: PIN belum dibuat
- `422 Unprocessable Entity`: Validasi gagal

## Pengecekan Status PIN

### 1. Saat Login

Saat pengguna login dengan email dan password, respons akan menyertakan informasi status PIN.

**Contoh Response Sukses Login Normal**:

```json
{
  "message": "Login berhasil",
  "user": {
    "id": 1,
    "name": "Pasien Test",
    "email": "pasien@example.com",
    "role": "pasien"
  },
  "token": "1|XAgB1sWyRRtIxMTsN8zsAOKV9dDgEb9DuZwJ4QFB",
  "has_pin": true
}
```

### 2. Informasi User

Saat mendapatkan informasi pengguna yang sedang login, respons akan menyertakan informasi status PIN.

**URL**: `/api/user`

**Metode**: `GET`

**Headers**:
- Authorization: Bearer {token}

**Contoh Response Sukses**:

```json
{
  "user": {
    "id": 1,
    "name": "Pasien Test",
    "email": "pasien@example.com",
    "role": "pasien"
  },
  "pasien": {
    "id": 1,
    "no_rm": "RM-001",
    "nik": "1234567890",
    "nama": "Pasien Test",
    "tanggal_lahir": "2000-01-01",
    "jenis_kelamin": "Laki-laki",
    "alamat": "Jl. Contoh No. 123",
    "no_telepon": "08123456789"
  },
  "has_pin": true
}
```

## Validasi PIN

Semua endpoint terkait PIN memvalidasi format PIN dengan aturan:
- Panjang harus tepat 6 karakter
- Hanya boleh berisi angka (0-9)
- Format validasi: `required|string|size:6|regex:/^[0-9]+$/`

## Alur Login Tanpa Password

Aplikasi ini mendukung alur login tanpa password menggunakan kombinasi verifikasi email dan PIN:

1. Pengguna memasukkan email mereka (`/api/verify-email`)
2. Sistem memverifikasi keberadaan email dan mengembalikan metode autentikasi yang tersedia
3. Jika pengguna memiliki PIN, klien dapat menampilkan form input PIN
4. Pengguna memasukkan PIN dan melakukan login (`/api/login-pin`)

Alur ini mengurangi hambatan login dengan menghilangkan kebutuhan untuk memasukkan password setiap kali.

## Perintah Artisan

Terdapat perintah artisan untuk membuat pengguna dengan PIN langsung:

```bash
php artisan users:create-default --name="Pasien Test" --email="pasien@example.com" --password="password123" --pin="123456"
```

Parameter opsional:
- `--name`: Nama pengguna (default: "Admin")
- `--email`: Email pengguna (default: "admin@example.com")
- `--password`: Password pengguna (default: "password")
- `--pin`: PIN 6 digit pengguna (default: "123456") 
