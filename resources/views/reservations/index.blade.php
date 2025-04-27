@extends('layouts.app')

@section('title', 'Mis Reservas - Travelasing')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1>Mis Reservas</h1>
            <p class="lead">Consulta y gestiona todas tus reservas de viaje.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('search') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Nueva Reserva
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Historial de Reservas</h5>
                </div>
                <div class="col-auto">
                    <form action="{{ route('reservations.index') }}" method="GET" class="d-flex">
                        <select name="status" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Todos los estados</option>
                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>En proceso</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Completado</option>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(count($reservations) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Ruta</th>
                                <th>Fecha</th>
                                <th>Asiento</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td><strong>{{ $reservation->reserv_code }}</strong></td>
                                    <td>{{ $reservation->route->route_from }} - {{ $reservation->route->route_to }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->depart)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $reservation->seat }}</td>
                                    <td>{{ number_format($reservation->price, 0, ',', '.') }}</td>
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
                                            <a href="{{ route('reservations.show', $reservation->id_reserv) }}" class="btn btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($reservation->status == 'Proses')
                                                <a href="{{ route('reservations.edit', $reservation->id_reserv) }}" class="btn btn-outline-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('reservations.destroy', $reservation->id_reserv) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Cancelar reserva"
                                                            onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?');">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('reservations.print', $reservation->id_reserv) }}" class="btn btn-outline-success" title="Imprimir ticket" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $reservations->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No tienes reservas que mostrar.
                    <a href="{{ route('search') }}" class="alert-link">¡Busca y reserva tu primer viaje ahora!</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
