@extends('layouts.app')

@section('title', 'Dashboard - Travelasing')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1>Selamat Datang, {{ Auth::user()->fullname }}</h1>
            <p class="lead">Kelola reservasi dan profil Anda dari panel ini.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Reservasi Saya</h5>
                        <h3 class="mb-0">{{ isset($reservations) ? $reservations->total() : 0 }}</h3>
                    </div>
                    <i class="fas fa-ticket-alt fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-primary border-top-0">
                    <a href="{{ route('reservations.index') }}" class="text-white text-decoration-none">
                        Lihat semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Cari Penerbangan</h5>
                        <p class="mb-0">Temukan tujuan selanjutnya</p>
                    </div>
                    <i class="fas fa-search fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-info border-top-0">
                    <a href="{{ route('search.form') }}" class="text-white text-decoration-none">
                        Cari sekarang <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Rute Tersedia</h5>
                        <p class="mb-0">Lihat semua rute</p>
                    </div>
                    <i class="fas fa-route fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-success border-top-0">
                    <a href="{{ route('routes.index') }}" class="text-white text-decoration-none">
                        Jelajahi <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Profil Saya</h5>
                        <p class="mb-0">Perbarui informasi</p>
                    </div>
                    <i class="fas fa-user-circle fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-warning border-top-0">
                    <a href="#" class="text-dark text-decoration-none">
                        Edit profil <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Reservasi Terbaru Saya</h5>
                </div>
                <div class="card-body">
                    @if(isset($reservations) && count($reservations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Rute</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td><strong>{{ $reservation->reserv_code }}</strong></td>
                                            <td>{{ $reservation->route->route_from }} - {{ $reservation->route->route_to }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->depart)->format('d/m/Y') }}</td>
                                            <td>
                                                @if($reservation->status == 'Proses')
                                                    <span class="badge bg-warning text-dark">Dalam Proses</span>
                                                @elseif($reservation->status == 'Selesai')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('reservations.show', $reservation->id_reserv) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('reservations.print', $reservation->id_reserv) }}" class="btn btn-outline-success">
                                                        <i class="fas fa-print"></i>
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
                            Anda tidak memiliki reservasi terbaru. <a href="{{ route('search.form') }}" class="alert-link">Cari penerbangan pertama Anda sekarang!</a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline-primary">Lihat semua reservasi saya</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Nama:</strong>
                            <span>{{ Auth::user()->fullname }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Nama Pengguna:</strong>
                            <span>{{ Auth::user()->username }}</span>
                        </li>
                        @if(Auth::user()->customer)
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Telepon:</strong>
                                <span>{{ Auth::user()->customer->phone }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Jenis Kelamin:</strong>
                                <span>{{ Auth::user()->customer->gender }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('search.form') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i> Cari Penerbangan
                        </a>
                        <a href="{{ route('routes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-route me-2"></i> Lihat Rute Tersedia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
