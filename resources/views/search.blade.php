@extends('layouts.app')

@section('title', 'Cari Tiket - Travelasing')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1>Cari Tiket Perjalanan</h1>
            <p class="lead">Temukan tiket terbaik untuk perjalanan Anda.</p>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-body p-4">
            <form action="{{ route('search.results') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="route_from" class="form-label">Kota Asal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-plane-departure"></i></span>
                            <input type="text" class="form-control" id="route_from" name="route_from" 
                                value="{{ request('route_from') }}" placeholder="Contoh: Jakarta" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="route_to" class="form-label">Kota Tujuan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-plane-arrival"></i></span>
                            <input type="text" class="form-control" id="route_to" name="route_to" 
                                value="{{ request('route_to') }}" placeholder="Contoh: Bali" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="depart_date" class="form-label">Tanggal Keberangkatan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input type="date" class="form-control" id="depart" name="depart" 
                                value="{{ request('depart', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="transport_type" class="form-label">Jenis Transportasi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-bus"></i></span>
                            <select class="form-select" id="transport_type" name="transport_type">
                                <option value="">Semua Jenis Transportasi</option>
                                @foreach($transportTypes as $type)
                                <option value="{{ $type->id_type_trans }}" {{ request('transport_type') == $type->id_type_trans ? 'selected' : '' }}>
                                    {{ $type->description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Cari Tiket
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tips Pencarian</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-lightbulb text-warning me-2"></i>Kapan Memesan?</h6>
                            <p>Pesan tiket setidaknya 1-2 minggu sebelum keberangkatan untuk mendapatkan harga terbaik.</p>
                            
                            <h6><i class="fas fa-lightbulb text-warning me-2"></i>Pilihan Kursi</h6>
                            <p>Tetapkan pilihan kursi Anda sedini mungkin untuk kenyamanan perjalanan.</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-lightbulb text-warning me-2"></i>Alternatif Tujuan</h6>
                            <p>Pertimbangkan untuk mencari kota tujuan alternatif yang berdekatan untuk mendapatkan harga lebih baik.</p>
                            
                            <h6><i class="fas fa-lightbulb text-warning me-2"></i>Musim Ramai</h6>
                            <p>Hindari memesan tiket saat musim liburan jika mencari harga yang lebih terjangkau.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <h2 class="mb-4">Destinasi Populer</h2>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card destination-card h-100">
                <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47" class="card-img-top" alt="Jakarta">
                <div class="card-body">
                    <h5 class="card-title">Jakarta</h5>
                    <p class="card-text">Jelajahi ibu kota Indonesia dengan berbagai atraksi dan kuliner lezat.</p>
                    <form action="{{ route('search.results') }}" method="GET">
                        <input type="hidden" name="route_to" value="Jakarta">
                        <button type="submit" class="btn btn-outline-primary">Cari Tiket ke Jakarta</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card destination-card h-100">
                <img src="https://images.unsplash.com/photo-1580861405977-9381fe4e597e" class="card-img-top" alt="Bali">
                <div class="card-body">
                    <h5 class="card-title">Bali</h5>
                    <p class="card-text">Nikmati keindahan pulau dewata dengan pantai dan budaya yang menakjubkan.</p>
                    <form action="{{ route('search.results') }}" method="GET">
                        <input type="hidden" name="route_to" value="Bali">
                        <button type="submit" class="btn btn-outline-primary">Cari Tiket ke Bali</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card destination-card h-100">
                <img src="https://images.unsplash.com/photo-1553855994-a53d4d6f783e" class="card-img-top" alt="Yogyakarta">
                <div class="card-body">
                    <h5 class="card-title">Yogyakarta</h5>
                    <p class="card-text">Rasakan kekayaan sejarah dan budaya di kota pelajar yang istimewa.</p>
                    <form action="{{ route('search.results') }}" method="GET">
                        <input type="hidden" name="route_to" value="Yogyakarta">
                        <button type="submit" class="btn btn-outline-primary">Cari Tiket ke Yogyakarta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .destination-card {
        transition: transform 0.3s ease;
        overflow: hidden;
    }
    
    .destination-card:hover {
        transform: translateY(-10px);
    }
    
    .destination-card img {
        height: 200px;
        object-fit: cover;
    }
</style>
@endsection
