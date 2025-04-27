# Travelasing API Documentation

Dokumentasi ini menjelaskan REST API endpoints yang tersedia di aplikasi Travelasing untuk digunakan oleh aplikasi eksternal.

## Base URL

```
http://localhost:8000/api
```

## Format Respons

Semua API endpoint mengembalikan respons dalam format JSON dengan struktur berikut:

```json
{
  "success": true/false,
  "message": "Deskripsi respons",
  "data": [], // Array objek atau objek tunggal,
  "errors": {} // Kesalahan validasi (jika ada)
}
```

## Autentikasi

Beberapa endpoint memerlukan autentikasi. Gunakan token Bearer di header untuk autentikasi:

```
Authorization: Bearer YOUR_API_TOKEN
```

## Endpoints

### 1. Tipe Penerbangan (Transport Types)

#### Mendapatkan Semua Tipe Penerbangan
- **URL**: `/transport-types`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Daftar semua tipe penerbangan

#### Mendapatkan Tipe Penerbangan Berdasarkan ID
- **URL**: `/transport-types/{id}`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Detail tipe penerbangan

#### Membuat Tipe Penerbangan Baru
- **URL**: `/transport-types`
- **Method**: `POST`
- **Auth Required**: Ya
- **Body**:
  ```json
  {
    "description": "Deskripsi tipe penerbangan"
  }
  ```
- **Response**: Tipe penerbangan yang baru dibuat

#### Memperbarui Tipe Penerbangan
- **URL**: `/transport-types/{id}`
- **Method**: `PUT`
- **Auth Required**: Ya
- **Body**:
  ```json
  {
    "description": "Deskripsi tipe penerbangan baru"
  }
  ```
- **Response**: Tipe penerbangan yang diperbarui

#### Menghapus Tipe Penerbangan
- **URL**: `/transport-types/{id}`
- **Method**: `DELETE`
- **Auth Required**: Ya
- **Response**: Pesan sukses

### 2. Maskapai (Transports)

#### Mendapatkan Semua Maskapai
- **URL**: `/transports`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Daftar semua maskapai

#### Mendapatkan Maskapai Berdasarkan ID
- **URL**: `/transports/{id}`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Detail maskapai

#### Membuat Maskapai Baru
- **URL**: `/transports`
- **Method**: `POST`
- **Auth Required**: Ya
- **Body**:
  ```json
  {
    "code": "GA",
    "description": "Garuda Indonesia",
    "seat": 180,
    "id_transport_type": 1
  }
  ```
- **Response**: Maskapai yang baru dibuat

#### Memperbarui Maskapai
- **URL**: `/transports/{id}`
- **Method**: `PUT`
- **Auth Required**: Ya
- **Body**:
  ```json
  {
    "code": "GA",
    "description": "Garuda Indonesia Airways",
    "seat": 200,
    "id_transport_type": 1
  }
  ```
- **Response**: Maskapai yang diperbarui

#### Menghapus Maskapai
- **URL**: `/transports/{id}`
- **Method**: `DELETE`
- **Auth Required**: Ya
- **Response**: Pesan sukses

### 3. Rute Penerbangan (Routes)

#### Mendapatkan Semua Rute
- **URL**: `/routes`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Daftar semua rute penerbangan

#### Mendapatkan Rute Berdasarkan ID
- **URL**: `/routes/{id}`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Detail rute penerbangan

#### Pencarian Rute
- **URL**: `/routes/search`
- **Method**: `POST`
- **Auth Required**: Tidak
- **Body**:
  ```json
  {
    "route_from": "Jakarta",
    "route_to": "Bali",
    "depart_date": "2025-05-01",
    "transport_id": 1,
    "transport_type_id": 1
  }
  ```
- **Response**: Daftar rute penerbangan yang sesuai kriteria

#### Membuat Rute Baru
- **URL**: `/routes`
- **Method**: `POST`
- **Auth Required**: Ya
- **Body**:
  ```json
  {
    "depart": "2025-05-01",
    "route_from": "Jakarta",
    "route_to": "Bali",
    "price": 1000000,
    "id_transport": 1
  }
  ```
- **Response**: Rute yang baru dibuat

#### Memperbarui Rute
- **URL**: `/routes/{id}`
- **Method**: `PUT`
- **Auth Required**: Ya
- **Body**:
  ```json
  {
    "depart": "2025-05-01",
    "route_from": "Jakarta",
    "route_to": "Surabaya",
    "price": 800000,
    "id_transport": 1
  }
  ```
- **Response**: Rute yang diperbarui

#### Menghapus Rute
- **URL**: `/routes/{id}`
- **Method**: `DELETE`
- **Auth Required**: Ya
- **Response**: Pesan sukses

### 4. Jadwal Penerbangan (Schedules)

#### Mendapatkan Semua Jadwal
- **URL**: `/schedules`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Daftar semua jadwal penerbangan

#### Mendapatkan Jadwal Berdasarkan ID
- **URL**: `/schedules/{id}`
- **Method**: `GET`
- **Auth Required**: Tidak
- **Response**: Detail jadwal penerbangan

#### Pencarian Jadwal Berdasarkan Tanggal
- **URL**: `/schedules/search/date`
- **Method**: `POST`
- **Auth Required**: Tidak
- **Body**:
  ```json
  {
    "start_date": "2025-05-01",
    "end_date": "2025-05-05"
  }
  ```
- **Response**: Daftar jadwal penerbangan pada rentang tanggal

#### Pencarian Jadwal Berdasarkan Rute
- **URL**: `/schedules/search/route`
- **Method**: `POST`
- **Auth Required**: Tidak
- **Body**:
  ```json
  {
    "route_from": "Jakarta",
    "route_to": "Bali",
    "date": "2025-05-01"
  }
  ```
- **Response**: Daftar jadwal penerbangan sesuai rute dan tanggal

#### Pencarian Jadwal Berdasarkan Maskapai
- **URL**: `/schedules/search/airline`
- **Method**: `POST`
- **Auth Required**: Tidak
- **Body**:
  ```json
  {
    "id_transport": 1
  }
  ```
- **Response**: Daftar jadwal penerbangan untuk maskapai tertentu

### 5. Autentikasi

#### Register
- **URL**: `/auth/register`
- **Method**: `POST`
- **Auth Required**: Tidak
- **Body**:
  ```json
  {
    "name": "User Name",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
  }
  ```
- **Response**: User dan token akses

#### Login
- **URL**: `/auth/login`
- **Method**: `POST`
- **Auth Required**: Tidak
- **Body**:
  ```json
  {
    "email": "user@example.com",
    "password": "password"
  }
  ```
- **Response**: User dan token akses

#### User Info
- **URL**: `/auth/user`
- **Method**: `GET`
- **Auth Required**: Ya
- **Response**: Informasi user yang sedang login

#### Logout
- **URL**: `/auth/logout`
- **Method**: `POST`
- **Auth Required**: Ya
- **Response**: Pesan sukses
