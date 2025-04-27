@extends('layouts.app')

@section('title', 'Dashboard Admin - Travelasing')

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
                        <a href="{{ route('admin.routes.index') }}" class="nav-link text-white">
                            <i class="fas fa-route me-2"></i> Rute
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.transports.index') }}" class="nav-link text-white">
                            <i class="fas fa-bus me-2"></i> Transportasi
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.transport-types.index') }}" class="nav-link text-white">
                            <i class="fas fa-tags me-2"></i> Tipe Transportasi
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.reservations.index') }}" class="nav-link text-white">
                            <i class="fas fa-ticket-alt me-2"></i> Reservasi
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                            <i class="fas fa-users me-2"></i> Pengguna
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
                    <p class="mb-0">Selamat datang, <strong>{{ Auth::guard('admin')->user()->username }}</strong></p>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Reservasi</h5>
                                    <h3 class="mb-0">{{ $totalReservations ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-ticket-alt fa-3x opacity-50"></i>
                            </div>
                            <div class="card-footer bg-primary border-top-0">
                                <a href="{{ route('admin.reservations.index') }}" class="text-white text-decoration-none">
                                    Lihat semua <i class="fas fa-arrow-right ms-1"></i>
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
                                    <h5 class="card-title">Transportasi</h5>
                                    <h3 class="mb-0">{{ $totalTransports ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-bus fa-3x opacity-50"></i>
                            </div>
                            <div class="card-footer bg-info border-top-0">
                                <a href="{{ route('admin.transports.index') }}" class="text-white text-decoration-none">
                                    Kelola <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card bg-warning text-dark">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Pengguna</h5>
                                    <h3 class="mb-0">{{ $totalUsers ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-users fa-3x opacity-50"></i>
                            </div>
                            <div class="card-footer bg-warning border-top-0">
                                <a href="{{ route('admin.users.index') }}" class="text-dark text-decoration-none">
                                    Kelola <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Reservasi Terbaru</h5>
                                <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-primary">Lihat semua</a>
                            </div>
                            <div class="card-body">
                                @if(isset($recentReservations) && count($recentReservations) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Pengguna</th>
                                                <th>Rute</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentReservations as $reservation)
                                            <tr>
                                                <td><strong>{{ $reservation->reserv_code }}</strong></td>
                                                <td>{{ $reservation->user->username }}</td>
                                                <td>{{ $reservation->route->route_from }} - {{ $reservation->route->route_to }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservation->depart)->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($reservation->status == 'Proses')
                                                        <span class="badge bg-warning text-dark">Diproses</span>
                                                    @elseif($reservation->status == 'Selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('admin.reservations.show', $reservation->id_reserv) }}" class="btn btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.reservations.edit', $reservation->id_reserv) }}" class="btn btn-outline-warning">
                                                            <i class="fas fa-edit"></i>
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
                                    Belum ada reservasi terbaru untuk ditampilkan.
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
                                    <a href="{{ route('admin.routes.create') }}" class="btn btn-success">
                                        <i class="fas fa-plus-circle me-2"></i> Rute Baru
                                    </a>
                                    <a href="{{ route('admin.transports.create') }}" class="btn btn-info text-white">
                                        <i class="fas fa-plus-circle me-2"></i> Transportasi Baru
                                    </a>
                                    <a href="{{ route('admin.transport-types.create') }}" class="btn btn-secondary">
                                        <i class="fas fa-plus-circle me-2"></i> Tipe Transportasi Baru
                                    </a>
                                    <a href="{{ route('admin.reservations.index') }}?status=Proses" class="btn btn-warning">
                                        <i class="fas fa-tasks me-2"></i> Reservasi Tertunda
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Statistik Sistem</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Reservasi Selesai
                                        <span class="badge bg-success rounded-pill">{{ $completedReservations ?? 0 }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Reservasi Diproses
                                        <span class="badge bg-warning text-dark rounded-pill">{{ $pendingReservations ?? 0 }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Tipe Transportasi
                                        <span class="badge bg-secondary rounded-pill">{{ $totalTransportTypes ?? 0 }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
