# Alur Login Tanpa Password

Aplikasi Puskesmas Kluwung mendukung login tanpa password untuk memudahkan pengguna, terutama pasien, dalam mengakses aplikasi. Berikut adalah alur login tanpa password yang diimplementasikan:

## Ringkasan Alur

```
┌────────────┐      ┌───────────────┐      ┌────────────────┐      ┌───────────────┐
│            │      │               │      │                │      │               │
│  Input     │──────▶  Verifikasi   │──────▶  Input PIN     │──────▶  Login        │
│  Email     │      │  Email        │      │  (jika ada)    │      │  Berhasil     │
│            │      │               │      │                │      │               │
└────────────┘      └───────────────┘      └────────────────┘      └───────────────┘n
```

## Proses Detail

### Langkah 1: Pengguna Memasukkan Email

Pada halaman login, pengguna hanya perlu memasukkan alamat email mereka, tanpa password.

### Langkah 2: Verifikasi Email

Setelah pengguna memasukkan email, aplikasi melakukan panggilan ke endpoint `/api/verify-email` untuk:
- Memeriksa apakah email terdaftar
- Mendapatkan informasi metode autentikasi yang tersedia (PIN dan/atau password)

**Contoh Response Verifikasi Email**:

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

### Langkah 3: Menampilkan Input PIN

Jika pengguna memiliki PIN (`has_pin: true`), aplikasi akan:
- Menampilkan form input PIN
- Meminta pengguna memasukkan PIN 6 digit

### Langkah 4: Login dengan PIN

Setelah pengguna memasukkan PIN, aplikasi melakukan panggilan ke endpoint `/api/login-pin` dengan email dan PIN yang dimasukkan.

**Contoh Request**:

```json
{
  "email": "pasien@example.com",
  "pin": "123456"
}
```

### Langkah 5: Login Berhasil

Jika PIN valid, pengguna akan berhasil login dan menerima token autentikasi.

**Contoh Response Login Berhasil**:

```json
{
  "success": true,
  "message": "Login dengan PIN berhasil",
  "user": {
    "id": 1,
    "name": "Pasien Test",
    "email": "pasien@example.com",
    "role": "pasien"
  },
  "token": "1|XAgB1sWyRRtIxMTsN8zsAOKV9dDgEb9DuZwJ4QFB"
}
```

## Keuntungan Login Tanpa Password

1. **Kemudahan Penggunaan** - Pengguna tidak perlu mengingat password yang rumit
2. **Pengalaman Pengguna yang Lebih Baik** - Proses login lebih cepat dan sederhana
3. **Keamanan yang Tetap Terjaga** - PIN 6 digit memberikan keamanan yang cukup untuk aplikasi kesehatan
4. **Login yang Fleksibel** - Pengguna tetap memiliki opsi login dengan password jika diperlukan

## Catatan Pengembangan

Pengembang aplikasi klien perlu mengimplementasikan alur UI sesuai dengan alur API ini. Umumnya alurnya sebagai berikut:

1. Tampilkan form input email
2. Setelah email dimasukkan, verifikasi dengan API
3. Berdasarkan response, tampilkan form PIN atau password
4. Selesaikan proses login sesuai metode yang dipilih

## Aspek Keamanan

Meskipun login tanpa password lebih mudah, tetap perhatikan aspek keamanan berikut:

1. PIN disimpan dalam bentuk terenkripsi (hashed) di database
2. Kegagalan login berulang sebaiknya diberi penundaan atau pembatasan
3. Untuk transaksi sensitif, pertimbangkan untuk tetap meminta verifikasi tambahan 
