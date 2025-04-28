@extends('layouts.app')

@section('title', 'Dokumentasi API - Travelasing API')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-2 bg-dark text-white" style="min-height: calc(100vh - 100px);">
            <div class="d-flex flex-column p-3">
                <h4 class="text-center my-3">Panel Admin</h4>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.transport-types.index') }}" class="nav-link text-white">
                            <i class="fas fa-tags me-2"></i> Tipe Penerbangan
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.transports.index') }}" class="nav-link text-white">
                            <i class="fas fa-plane me-2"></i> Maskapai
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.routes.index') }}" class="nav-link text-white">
                            <i class="fas fa-route me-2"></i> Rute Penerbangan
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.schedules.index') }}" class="nav-link text-white">
                            <i class="fas fa-calendar-alt me-2"></i> Jadwal Penerbangan
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.api-docs') }}" class="nav-link active text-white">
                            <i class="fas fa-file-code me-2"></i> Dokumentasi API
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a href="{{ route('admin.logout') }}" class="nav-link text-danger" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-md-10">
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Dokumentasi API Travelasing</h1>
                    <a href="{{ route('admin.api-logs') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i> Lihat Log API
                    </a>
                </div>
                
                <div class="alert alert-info mb-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi API</h5>
                    <p class="mb-0">API ini menyediakan akses ke data penerbangan yang dikelola melalui sistem Travelasing. Semua endpoint dikembalikan dalam format JSON dengan struktur respons yang konsisten.</p>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Autentikasi API</h5>
                    </div>
                    <div class="card-body">
                        <p>API ini menggunakan Laravel Sanctum untuk autentikasi. Untuk mengakses endpoint yang dilindungi, Anda perlu mendapatkan token autentikasi terlebih dahulu.</p>
                        
                        <h6 class="mt-4 mb-3">Endpoint Autentikasi</h6>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Endpoint</th>
                                        <th>Metode</th>
                                        <th>Deskripsi</th>
                                        <th>Parameter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>/api/auth/register</code></td>
                                        <td><span class="badge bg-success">POST</span></td>
                                        <td>Mendaftarkan pengguna baru</td>
                                        <td>
                                            <ul class="mb-0">
                                                <li><code>username</code> (string) - Nama pengguna</li>
                                                <li><code>fullname</code> (string) - Nama lengkap</li>
                                                <li><code>email</code> (string) - Alamat email</li>
                                                <li><code>password</code> (string) - Kata sandi</li>
                                                <li><code>password_confirmation</code> (string) - Konfirmasi kata sandi</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>/api/auth/login</code></td>
                                        <td><span class="badge bg-success">POST</span></td>
                                        <td>Login dan dapatkan token API</td>
                                        <td>
                                            <ul class="mb-0">
                                                <li><code>email</code> (string) - Alamat email</li>
                                                <li><code>password</code> (string) - Kata sandi</li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <h6 class="mt-4 mb-2">Contoh Login</h6>
                        <pre class="bg-light p-3 rounded"><code>POST /api/auth/login
Content-Type: application/json

{
    "email": "apitest@example.com",
    "password": "password"
}

Response:
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "token": "1|abcdef1234567890...",
        "user": {
            "id": 1,
            "username": "apitest",
            "fullname": "API Test User",
            "email": "apitest@example.com"
        }
    }
}</code></pre>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Endpoint API</h5>
                    </div>
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-transport-types-tab" data-bs-toggle="tab" data-bs-target="#nav-transport-types" type="button" role="tab">Tipe Penerbangan</button>
                                <button class="nav-link" id="nav-transports-tab" data-bs-toggle="tab" data-bs-target="#nav-transports" type="button" role="tab">Maskapai</button>
                                <button class="nav-link" id="nav-routes-tab" data-bs-toggle="tab" data-bs-target="#nav-routes" type="button" role="tab">Rute</button>
                                <button class="nav-link" id="nav-schedules-tab" data-bs-toggle="tab" data-bs-target="#nav-schedules" type="button" role="tab">Jadwal</button>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <!-- Tipe Penerbangan API -->
                            <div class="tab-pane fade show active" id="nav-transport-types" role="tabpanel">
                                <h5 class="mb-3">Tipe Penerbangan API (Airplane Types)</h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Endpoint</th>
                                                <th>Metode</th>
                                                <th>Deskripsi</th>
                                                <th>Autentikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>/api/transport-types</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan semua tipe penerbangan</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transport-types/{id}</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan detail tipe penerbangan</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transport-types</code></td>
                                                <td><span class="badge bg-success">POST</span></td>
                                                <td>Membuat tipe penerbangan baru</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transport-types/{id}</code></td>
                                                <td><span class="badge bg-warning text-dark">PUT</span></td>
                                                <td>Memperbarui tipe penerbangan</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transport-types/{id}</code></td>
                                                <td><span class="badge bg-danger">DELETE</span></td>
                                                <td>Menghapus tipe penerbangan</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h6 class="mt-4 mb-2">Contoh Respons</h6>
                                <pre class="bg-light p-3 rounded"><code>GET /api/transport-types

Response:
{
    "success": true,
    "message": "Data tipe penerbangan berhasil diambil",
    "data": [
        {
            "id_transport_type": 1,
            "description": "Pesawat"
        }
    ]
}</code></pre>
                            </div>
                            
                            <!-- Maskapai API -->
                            <div class="tab-pane fade" id="nav-transports" role="tabpanel">
                                <h5 class="mb-3">Maskapai API (Airlines)</h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Endpoint</th>
                                                <th>Metode</th>
                                                <th>Deskripsi</th>
                                                <th>Autentikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>/api/transports</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan semua maskapai</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transports/{id}</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan detail maskapai</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transports</code></td>
                                                <td><span class="badge bg-success">POST</span></td>
                                                <td>Membuat maskapai baru</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transports/{id}</code></td>
                                                <td><span class="badge bg-warning text-dark">PUT</span></td>
                                                <td>Memperbarui maskapai</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/transports/{id}</code></td>
                                                <td><span class="badge bg-danger">DELETE</span></td>
                                                <td>Menghapus maskapai</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h6 class="mt-4 mb-2">Contoh Respons</h6>
                                <pre class="bg-light p-3 rounded"><code>GET /api/transports

Response:
{
    "success": true,
    "message": "Data maskapai berhasil diambil",
    "data": [
        {
            "id_transport": 1,
            "code": "GA",
            "description": "Garuda Indonesia",
            "seat": 180,
            "id_transport_type": 1,
            "transport_type": {
                "id_transport_type": 1,
                "description": "Pesawat"
            }
        },
        {
            "id_transport": 2,
            "code": "JT",
            "description": "Lion Air",
            "seat": 150,
            "id_transport_type": 1,
            "transport_type": {
                "id_transport_type": 1,
                "description": "Pesawat"
            }
        }
    ]
}</code></pre>
                            </div>
                            
                            <!-- Rute API -->
                            <div class="tab-pane fade" id="nav-routes" role="tabpanel">
                                <h5 class="mb-3">Rute API (Routes)</h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Endpoint</th>
                                                <th>Metode</th>
                                                <th>Deskripsi</th>
                                                <th>Autentikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>/api/routes</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan semua rute</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/routes/{id}</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan detail rute</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/routes/search</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mencari rute berdasarkan kriteria</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/routes</code></td>
                                                <td><span class="badge bg-success">POST</span></td>
                                                <td>Membuat rute baru</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/routes/{id}</code></td>
                                                <td><span class="badge bg-warning text-dark">PUT</span></td>
                                                <td>Memperbarui rute</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/routes/{id}</code></td>
                                                <td><span class="badge bg-danger">DELETE</span></td>
                                                <td>Menghapus rute</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h6 class="mt-4 mb-2">Parameter Pencarian</h6>
                                <p>Endpoint <code>/api/routes/search</code> menerima parameter berikut:</p>
                                <ul>
                                    <li><code>route_from</code> (string) - Kota asal</li>
                                    <li><code>route_to</code> (string) - Kota tujuan</li>
                                    <li><code>id_transport</code> (integer, opsional) - ID maskapai</li>
                                </ul>
                                
                                <h6 class="mt-4 mb-2">Contoh Respons</h6>
                                <pre class="bg-light p-3 rounded"><code>GET /api/routes/search?route_from=Jakarta&route_to=Bali

Response:
{
    "success": true,
    "message": "Data rute berhasil ditemukan",
    "data": [
        {
            "id_route": 1,
            "route_from": "Jakarta",
            "route_to": "Bali",
            "depart": "2025-05-01 08:00:00",
            "price": 1500000,
            "id_transport": 1,
            "transport": {
                "id_transport": 1,
                "code": "GA",
                "description": "Garuda Indonesia",
                "transport_type": {
                    "id_transport_type": 1,
                    "description": "Pesawat"
                }
            }
        }
    ]
}</code></pre>
                            </div>
                            
                            <!-- Jadwal API -->
                            <div class="tab-pane fade" id="nav-schedules" role="tabpanel">
                                <h5 class="mb-3">Jadwal API (Schedules)</h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Endpoint</th>
                                                <th>Metode</th>
                                                <th>Deskripsi</th>
                                                <th>Autentikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>/api/schedules</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan semua jadwal</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/schedules/{id}</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mendapatkan detail jadwal</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>/api/schedules/search</code></td>
                                                <td><span class="badge bg-primary">GET</span></td>
                                                <td>Mencari jadwal berdasarkan kriteria</td>
                                                <td><span class="badge bg-success">Ya</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h6 class="mt-4 mb-2">Parameter Pencarian</h6>
                                <p>Endpoint <code>/api/schedules/search</code> menerima parameter berikut:</p>
                                <ul>
                                    <li><code>route_from</code> (string) - Kota asal</li>
                                    <li><code>route_to</code> (string) - Kota tujuan</li>
                                    <li><code>depart_date</code> (string, format: Y-m-d) - Tanggal keberangkatan</li>
                                    <li><code>id_transport</code> (integer, opsional) - ID maskapai</li>
                                </ul>
                                
                                <h6 class="mt-4 mb-2">Contoh Respons</h6>
                                <pre class="bg-light p-3 rounded"><code>GET /api/schedules/search?route_from=Jakarta&route_to=Bali&depart_date=2025-05-01

Response:
{
    "success": true,
    "message": "Data jadwal berhasil ditemukan",
    "data": [
        {
            "id_schedule": 1,
            "id_route": 1,
            "depart_time": "2025-05-01 08:00:00",
            "arrival_time": "2025-05-01 10:00:00",
            "available_seats": 150,
            "price": 1500000,
            "status": "Scheduled",
            "route": {
                "id_route": 1,
                "route_from": "Jakarta",
                "route_to": "Bali",
                "transport": {
                    "id_transport": 1,
                    "code": "GA",
                    "description": "Garuda Indonesia"
                }
            }
        }
    ]
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Struktur Respons API</h5>
                    </div>
                    <div class="card-body">
                        <p>Semua respons API menggunakan format JSON dengan struktur berikut:</p>
                        
                        <pre class="bg-light p-3 rounded"><code>{
    "success": boolean,      // Status sukses atau gagal
    "message": string,       // Pesan status
    "data": array|object,    // Data respons (opsional)
    "errors": array          // Pesan error (jika ada, opsional)
}</code></pre>
                        
                        <h6 class="mt-4 mb-3">Kode Status HTTP</h6>
                        <ul>
                            <li><code>200 OK</code> - Permintaan berhasil</li>
                            <li><code>201 Created</code> - Resource berhasil dibuat</li>
                            <li><code>400 Bad Request</code> - Parameter tidak valid</li>
                            <li><code>401 Unauthorized</code> - Autentikasi gagal</li>
                            <li><code>403 Forbidden</code> - Tidak memiliki izin</li>
                            <li><code>404 Not Found</code> - Resource tidak ditemukan</li>
                            <li><code>500 Internal Server Error</code> - Kesalahan server</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
