@extends('layouts.app')

@section('title', 'Reservasi Saya - Travelasing')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1>Reservasi Saya</h1>
            <p class="lead">Lihat dan kelola semua reservasi perjalanan Anda.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('search') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Reservasi Baru
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Riwayat Reservasi</h5>
                </div>
                <div class="col-auto">
                    <form action="{{ route('reservations.index') }}" method="GET" class="d-flex">
                        <select name="status" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Semua status</option>
                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Sedang diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Filter</button>
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
                                <th>Kode</th>
                                <th>Rute</th>
                                <th>Tanggal</th>
                                <th>Kursi</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
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
                                            <span class="badge bg-warning text-dark">Sedang diproses</span>
                                        @elseif($reservation->status == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('reservations.show', $reservation->id_reserv) }}" class="btn btn-outline-primary" title="Lihat detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($reservation->status == 'Proses')
                                                <a href="{{ route('reservations.edit', $reservation->id_reserv) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('reservations.destroy', $reservation->id_reserv) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Batalkan reservasi"
                                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('reservations.print', $reservation->id_reserv) }}" class="btn btn-outline-success" title="Cetak tiket" target="_blank">
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
                    <i class="fas fa-info-circle me-2"></i> Anda tidak memiliki reservasi untuk ditampilkan.
                    <a href="{{ route('search') }}" class="alert-link">Cari dan pesan perjalanan pertama Anda sekarang!</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
