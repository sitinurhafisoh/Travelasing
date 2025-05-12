@extends('layouts.app')

@section('title', 'Hasil Pencarian - Travelasing')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1>Hasil Pencarian</h1>
            <p class="lead">Menemukan tiket dari {{ request('route_From') }} ke {{ request('route_To') }}</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('search.form') }}" class="btn btn-outline-secondary">
                <i class="fas fa-search me-2"></i>Pencarian Baru
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filter Pencarian</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('search.results') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="route_from" class="form-label">Dari</label>
                        <input type="text" class="form-control" id="route_from" name="route_from" value="{{ request('route_From') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="route_to" class="form-label">Ke</label>
                        <input type="text" class="form-control" id="route_to" name="route_to" value="{{ request('route_To') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="depart_date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="depart_date" name="depart_date" value="{{ request('depart') }}
?? date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="transport_type" class="form-label">Jenis Transportasi</label>
                        <select class="form-select" id="transport_type" name="transport_type">
                            <option value="">Semua Jenis</option>
                            @foreach($transportTypes as $type)
                            <option value="{{ $type->id_type_trans }}" {{ request('transport_type') == $type->id_type_trans ? 'selected' : '' }}>
                                {{ $type->description }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Perbarui Pencarian
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(count($routes) > 0)
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <i class="fas fa-info-circle me-2"></i>Ditemukan {{ count($routes) }} rute tersedia untuk tanggal {{ \Carbon\Carbon::parse (request('depart')) ->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($routes as $route)
            <div class="col-md-12 mb-4">
                <div class="card route-card shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="transport-icon me-3">
                                        @if($route->transport->transportType->description == 'Pesawat')
                                            <i class="fas fa-plane fa-2x text-primary"></i>
                                        @elseif($route->transport->transportType->description == 'Kereta')
                                            <i class="fas fa-train fa-2x text-success"></i>
                                        @elseif($route->transport->transportType->description == 'Bus')
                                            <i class="fas fa-bus fa-2x text-warning"></i>
                                        @else
                                            <i class="fas fa-ship fa-2x text-info"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $route->transport->description }}</h6>
                                        <small class="text-muted">{{ $route->transport->transportType->description }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="route-points text-center">
                                    <h5 class="mb-0">{{ $route->route_from }}</h5>
                                    <div class="route-line my-2">
                                        <i class="fas fa-circle"></i>
                                        <hr>
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <h5 class="mb-0">{{ $route->route_to }}</h5>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">Keberangkatan</h6>
                                    <h5>{{ \Carbon\Carbon::parse($route->depart)->format('H:i') }}</h5>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($route->depart)->format('d M Y') }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-end">
                                    <h6 class="text-muted mb-2">Harga per orang</h6>
                                    <h4 class="text-primary mb-3">Rp {{ number_format($route->price, 0, ',', '.') }}</h4>
                                    <div class="d-grid">
                                    <a href="http://localhost:8001/ticketing/form?route_id={{ $route->id_route }}&transport={{ $route->transport->description }}&from={{ $route->route_from }}&to={{ $route->route_to }}&departure={{ $route->depart }}&price={{ $route->price }}" class="btn btn-primary">
                                        <i class="fas fa-ticket-alt me-2"></i>Pesan Sekarang
                                    </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col-md-8">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Kode Transportasi: {{ $route->transport->trans_code }} | 
                                    Kursi Tersedia: {{ $route->transport->seat }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-sm btn-link route-details-btn" type="button" data-bs-toggle="collapse" data-bs-target="#routeDetails{{ $route->id_route }}">
                                    Lihat Detail <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </div>
                        </div>
                        <div class="collapse mt-3" id="routeDetails{{ $route->id_route }}">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Informasi Transportasi</h6>
                                    <p><strong>Deskripsi:</strong> {{ $route->transport->description }}</p>
                                    <p><strong>Tipe:</strong> {{ $route->transport->transportType->description }}</p>
                                    <p><strong>Kode:</strong> {{ $route->transport->code }}</p>
                                    <p><strong>Kapasitas:</strong> {{ $route->transport->seat }} kursi</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Informasi Perjalanan</h6>
                                    <p><strong>Dari:</strong> {{ $route->route_from }}</p>
                                    <p><strong>Ke:</strong> {{ $route->route_to }}</p>
                                    <p><strong>Tanggal & Waktu:</strong> {{ \Carbon\Carbon::parse($route->depart)->format('d M Y H:i') }}</p>
                                    <p><strong>Harga:</strong> Rp {{ number_format($route->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <img src="https://img.icons8.com/fluency/96/000000/nothing-found.png" alt="No results" class="mb-3">
                <h3>Maaf, Tidak Ada Rute yang Tersedia</h3>
                <p class="lead">Tidak ada rute perjalanan yang ditemukan dari {{ request('route_From') }} ke {{ request('route_To') }} untuk tanggal yang dipilih.</p>
                <div class="mt-4">
                    <a href="{{ route('search.form') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Coba Pencarian Lain
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .route-card {
        transition: transform 0.2s ease-in-out;
    }
    
    .route-card:hover {
        transform: translateY(-5px);
    }
    
    .route-line {
        position: relative;
        width: 100%;
        height: 2px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .route-line hr {
        position: absolute;
        width: 100%;
        margin: 0;
        border-top: 2px dashed #ccc;
        z-index: 1;
    }
    
    .route-line i {
        background-color: white;
        z-index: 2;
        position: relative;
        color: #0d6efd;
    }
    
    .route-details-btn {
        text-decoration: none;
    }
</style>
@endsection
