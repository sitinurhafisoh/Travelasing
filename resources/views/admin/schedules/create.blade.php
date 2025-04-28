@extends('layouts.app')

@section('title', 'Tambah Jadwal Penerbangan - Travelasing API')

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
                    <h1>Tambah Jadwal Penerbangan Baru</h1>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Form Jadwal Penerbangan</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.schedules.store') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="route_id" class="form-label">Rute Penerbangan <span class="text-danger">*</span></label>
                                    <select name="route_id" id="route_id" class="form-select @error('route_id') is-invalid @enderror" required>
                                        <option value="">Pilih Rute</option>
                                        @foreach($routes as $route)
                                            <option value="{{ $route->id_route }}" {{ old('route_id', $selectedRouteId) == $route->id_route ? 'selected' : '' }}>
                                                {{ $route->route_from }} - {{ $route->route_to }} ({{ $route->transport->description }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('route_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="depart_time" class="form-label">Waktu Keberangkatan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="depart_time" id="depart_time" class="form-control @error('depart_time') is-invalid @enderror" value="{{ old('depart_time') }}" required>
                                    @error('depart_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="arrival_time" class="form-label">Waktu Kedatangan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="arrival_time" id="arrival_time" class="form-control @error('arrival_time') is-invalid @enderror" value="{{ old('arrival_time') }}" required>
                                    @error('arrival_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="available_seats" class="form-label">Kursi Tersedia <span class="text-danger">*</span></label>
                                    <input type="number" name="available_seats" id="available_seats" class="form-control @error('available_seats') is-invalid @enderror" value="{{ old('available_seats') }}" min="1" required>
                                    @error('available_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="Scheduled" {{ old('status') == 'Scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="Delayed" {{ old('status') == 'Delayed' ? 'selected' : '' }}>Tertunda</option>
                                        <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary me-md-2">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Simpan Jadwal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-populate available seats based on route selection
    document.getElementById('route_id').addEventListener('change', function() {
        const routeId = this.value;
        const routes = @json($routes);
        
        if (routeId) {
            const selectedRoute = routes.find(route => route.id_route == routeId);
            if (selectedRoute && selectedRoute.transport) {
                document.getElementById('available_seats').value = selectedRoute.transport.seat;
            }
        }
    });
    
    // Trigger change event if a route is already selected
    if (document.getElementById('route_id').value) {
        document.getElementById('route_id').dispatchEvent(new Event('change'));
    }
</script>
@endsection
