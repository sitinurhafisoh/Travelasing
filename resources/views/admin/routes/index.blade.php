@extends('layouts.app')

@section('title', 'Kelola Rute Penerbangan - Travelasing API')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Admin -->
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
                        <a href="{{ route('admin.routes.index') }}" class="nav-link active text-white">
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
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.api-logs') }}" class="nav-link text-white">
                            <i class="fas fa-history me-2"></i> Log API
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a href="#" class="nav-link text-danger" 
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
        
        <!-- Konten Utama -->
        <div class="col-md-10">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Kelola Rute Penerbangan</h2>
                    <a href="{{ route('admin.routes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Rute Baru
                    </a>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="15%">Keberangkatan</th>
                                        <th width="15%">Dari</th>
                                        <th width="15%">Tujuan</th>
                                        <th width="15%">Harga</th>
                                        <th width="15%">Maskapai</th>
                                        <th width="25%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($routes->count() > 0)
                                        @foreach($routes as $route)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($route->depart)->format('d M Y H:i') }}</td>
                                                <td>{{ $route->route_from }}</td>
                                                <td>{{ $route->route_to }}</td>
                                                <td>Rp {{ number_format($route->price, 0, ',', '.') }}</td>
                                                <td>{{ $route->transport->description ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.routes.edit', $route->id_route) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.routes.destroy', $route->id_route) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus rute ini?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data rute penerbangan.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $routes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
