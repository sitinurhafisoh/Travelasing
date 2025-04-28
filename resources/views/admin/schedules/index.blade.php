@extends('layouts.app')

@section('title', 'Kelola Jadwal Penerbangan - Travelasing API')

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
                        <a href="{{ route('admin.schedules.index') }}" class="nav-link active text-white">
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
                    <h1>Kelola Jadwal Penerbangan</h1>
                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Jadwal Baru
                    </a>
                </div>
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Jadwal Penerbangan</h5>
                        <div>
                            <form action="{{ route('admin.schedules.index') }}" method="GET" class="d-flex">
                                <input type="date" name="date" class="form-control me-2" value="{{ request('date') ?? date('Y-m-d') }}">
                                <button type="submit" class="btn btn-outline-primary">Filter</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Rute</th>
                                        <th>Maskapai</th>
                                        <th>Keberangkatan</th>
                                        <th>Kedatangan</th>
                                        <th>Kursi Tersedia</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($schedules) > 0)
                                        @foreach($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->id_schedule }}</td>
                                            <td>{{ $schedule->route->route_from }} - {{ $schedule->route->route_to }}</td>
                                            <td>{{ $schedule->route->transport->description }}</td>
                                            <td>{{ $schedule->depart_time->format('d/m/Y H:i') }}</td>
                                            <td>{{ $schedule->arrival_time->format('d/m/Y H:i') }}</td>
                                            <td>{{ $schedule->available_seats }}</td>
                                            <td>{{ number_format($schedule->price, 0, ',', '.') }}</td>
                                            <td>
                                                @if($schedule->status == 'Scheduled')
                                                    <span class="badge bg-success">Terjadwal</span>
                                                @elseif($schedule->status == 'Delayed')
                                                    <span class="badge bg-warning text-dark">Tertunda</span>
                                                @elseif($schedule->status == 'Cancelled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $schedule->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.schedules.edit', $schedule->id_schedule) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.schedules.destroy', $schedule->id_schedule) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada jadwal penerbangan untuk ditampilkan</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
