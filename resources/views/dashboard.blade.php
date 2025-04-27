@extends('layouts.app')

@section('title', 'Dashboard - Travelasing')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1>Bienvenido, {{ Auth::user()->fullname }}</h1>
            <p class="lead">Gestiona tus reservas y perfil desde este panel.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Mis Reservas</h5>
                        <h3 class="mb-0">{{ isset($reservations) ? $reservations->total() : 0 }}</h3>
                    </div>
                    <i class="fas fa-ticket-alt fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-primary border-top-0">
                    <a href="{{ route('reservations.index') }}" class="text-white text-decoration-none">
                        Ver todas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Buscar Vuelos</h5>
                        <p class="mb-0">Encuentra tu próximo destino</p>
                    </div>
                    <i class="fas fa-search fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-info border-top-0">
                    <a href="{{ route('search') }}" class="text-white text-decoration-none">
                        Buscar ahora <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Rutas Disponibles</h5>
                        <p class="mb-0">Ver todas las rutas</p>
                    </div>
                    <i class="fas fa-route fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-success border-top-0">
                    <a href="{{ route('routes.index') }}" class="text-white text-decoration-none">
                        Explorar <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Mi Perfil</h5>
                        <p class="mb-0">Actualizar información</p>
                    </div>
                    <i class="fas fa-user-circle fa-3x opacity-50"></i>
                </div>
                <div class="card-footer bg-warning border-top-0">
                    <a href="#" class="text-dark text-decoration-none">
                        Editar perfil <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Mis Reservas Recientes</h5>
                </div>
                <div class="card-body">
                    @if(isset($reservations) && count($reservations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Ruta</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
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
                                                    <span class="badge bg-warning text-dark">En proceso</span>
                                                @elseif($reservation->status == 'Selesai')
                                                    <span class="badge bg-success">Completado</span>
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
                            No tienes reservas recientes. <a href="{{ route('search') }}" class="alert-link">¡Busca tu primer vuelo ahora!</a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline-primary">Ver todas mis reservas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Información de la Cuenta</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Nombre:</strong>
                            <span>{{ Auth::user()->fullname }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Nombre de Usuario:</strong>
                            <span>{{ Auth::user()->username }}</span>
                        </li>
                        @if(Auth::user()->customer)
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Teléfono:</strong>
                                <span>{{ Auth::user()->customer->phone }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Género:</strong>
                                <span>{{ Auth::user()->customer->gender }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('search') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i> Buscar Vuelos
                        </a>
                        <a href="{{ route('routes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-route me-2"></i> Ver Rutas Disponibles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
