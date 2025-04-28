@extends('layouts.app')

@section('title', 'Dashboard Admin - Travelasing API')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-2 bg-dark text-white" style="min-height: calc(100vh - 100px);">
            <div class="d-flex flex-column p-3">
                <h4 class="text-center my-3">Panel Admin</h4>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link active text-white">
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
                        <a href="{{ route('admin.api-docs') }}" class="nav-link text-white">
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
                    <h1>Dashboard Admin</h1>
                    <p class="mb-0">Selamat datang, <strong>{{ Auth::user()->username }}</strong></p>
                </div>

                <div class="alert alert-info mb-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Travelasing API Provider</h5>
                    <p class="mb-0">Sistem ini berfungsi sebagai penyedia API untuk layanan penerbangan. Kelola data penerbangan yang akan diakses melalui API.</p>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Maskapai</h5>
                                    <h3 class="mb-0">{{ $totalTransports ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-plane fa-3x opacity-50"></i>
                            </div>
                            <div class="card-footer bg-primary border-top-0">
                                <a href="{{ route('admin.transports.index') }}" class="text-white text-decoration-none">
                                    Kelola <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card bg-success text-white">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Rute</h5>
                                    <h3 class="mb-0">{{ $totalRoutes ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-route fa-3x opacity-50"></i>
                            </div>
                            <div class="card-footer bg-success border-top-0">
                                <a href="{{ route('admin.routes.index') }}" class="text-white text-decoration-none">
                                    Kelola <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card bg-info text-white">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Jadwal</h5>
                                    <h3 class="mb-0">{{ $totalSchedules ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                            </div>
                            <div class="card-footer bg-info border-top-0">
                                <a href="{{ route('admin.schedules.index') }}" class="text-white text-decoration-none">
                                    Kelola <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card bg-warning text-dark">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">API Requests</h5>
                                    <h3 class="mb-0">{{ $totalApiRequests ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-exchange-alt fa-3x opacity-50"></i>
                            </div>
                            <div class="card-footer bg-warning border-top-0">
                                <a href="{{ route('admin.api-logs') }}" class="text-dark text-decoration-none">
                                    Lihat Log <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Rute Penerbangan Terbaru</h5>
                                <a href="{{ route('admin.routes.index') }}" class="btn btn-sm btn-primary">Lihat semua</a>
                            </div>
                            <div class="card-body">
                                @if(isset($recentRoutes) && count($recentRoutes) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Dari</th>
                                                <th>Ke</th>
                                                <th>Maskapai</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentRoutes as $route)
                                            <tr>
                                                <td>{{ $route->route_from }}</td>
                                                <td>{{ $route->route_to }}</td>
                                                <td>{{ $route->transport->description }}</td>
                                                <td>{{ number_format($route->price, 0, ',', '.') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('admin.routes.edit', $route->id_route) }}" class="btn btn-outline-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.schedules.create', ['route_id' => $route->id_route]) }}" class="btn btn-outline-success">
                                                            <i class="fas fa-calendar-plus"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="alert alert-info">
                                    Belum ada rute penerbangan untuk ditampilkan.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Aksi Cepat</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.transports.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plane-departure me-2"></i>Tambah Maskapai Baru
                                    </a>
                                    <a href="{{ route('admin.routes.create') }}" class="btn btn-success">
                                        <i class="fas fa-route me-2"></i>Tambah Rute Baru
                                    </a>
                                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-info text-white">
                                        <i class="fas fa-calendar-plus me-2"></i>Tambah Jadwal Baru
                                    </a>
                                    <a href="{{ route('admin.api-docs') }}" class="btn btn-secondary">
                                        <i class="fas fa-file-code me-2"></i>Lihat Dokumentasi API
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Statistik API</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="apiRequestsChart" width="100%" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample data for API requests chart
    const ctx = document.getElementById('apiRequestsChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'API Requests',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: '#3490dc',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
