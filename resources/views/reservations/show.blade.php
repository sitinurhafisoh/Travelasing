@extends('layouts.app')

@section('title', 'Detail Reservasi - Travelasing')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1>Detail Reservasi</h1>
            <p class="lead">Informasi lengkap reservasi Anda.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke reservasi saya
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Tiket</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Kode Reservasi</h6>
                            <h4>{{ $reservation->reserv_code }}</h4>
                        </div>
                        <div class="col-md-6 mb-3 text-md-end">
                            <h6 class="text-muted">Status</h6>
                            @if($reservation->status == 'Proses')
                                <h4><span class="badge bg-warning text-dark">Sedang diproses</span></h4>
                            @elseif($reservation->status == 'Selesai')
                                <h4><span class="badge bg-success">Selesai</span></h4>
                            @else
                                <h4><span class="badge bg-secondary">{{ $reservation->status }}</span></h4>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted">Rute</h6>
                                <h5>{{ $reservation->route->route_from }} - {{ $reservation->route->route_to }}</h5>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted">Tanggal dan Jam</h6>
                                <h5>{{ \Carbon\Carbon::parse($reservation->depart)->format('d/m/Y H:i') }}</h5>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted">Kursi</h6>
                                <h5>{{ $reservation->seat }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted">Transportasi</h6>
                                <h5>{{ $reservation->route->transport->trans_code }} - {{ $reservation->route->transport->description }}</h5>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted">Jenis Transportasi</h6>
                                <h5>{{ $reservation->route->transport->transportType->description }}</h5>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted">Harga</h6>
                                <h5>{{ number_format($reservation->price, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted">Detail Reservasi</h6>
                        <p>{{ $reservation->reserv_desc ?: 'Tidak ada detail tambahan' }}</p>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <span>Dipesan pada: {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i') }}</span>
                    
                    <div>
                        @if($reservation->status == 'Proses')
                            <a href="{{ route('reservations.edit', $reservation->id_reserv) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('reservations.destroy', $reservation->id_reserv) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                                    <i class="fas fa-times me-1"></i> Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Penumpang</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Nama</h6>
                        <h5>{{ Auth::user()->customer->name }}</h5>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Jenis Kelamin</h6>
                        <h5>{{ Auth::user()->customer->gender }}</h5>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Telepon</h6>
                        <h5>{{ Auth::user()->customer->phone }}</h5>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Alamat</h6>
                        <p>{{ Auth::user()->customer->address }}</p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('reservations.print', $reservation->id_reserv) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-print me-2"></i> Cetak Tiket
                        </a>
                        <a href="{{ route('search') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-search me-2"></i> Cari Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
