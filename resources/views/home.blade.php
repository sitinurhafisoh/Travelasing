@extends('layouts.app')

@section('title', 'Beranda - Travelasing')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold mb-4">Pesan Tiket Perjalanan Anda dengan Mudah</h1>
                <p class="lead mb-4">Temukan dan booking tiket perjalanan dengan harga terbaik untuk destinasi favorit Anda</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="{{ route('search') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                        <i class="fas fa-search me-2"></i>Cari Tiket
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="fas fa-user-plus me-2"></i>Daftar
                    </a>
                    @endguest
                </div>
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <img src="https://images.unsplash.com/photo-1564957341299-80122e5f916e" class="img-fluid rounded shadow" alt="Travelling">
            </div>
        </div>
    </div>
</div>

<!-- Search Form Section -->
<div class="search-section">
    <div class="container">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Cari Tiket Perjalanan</h3>
                <form action="{{ route('search.results') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="route_from" class="form-label">Dari</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-plane-departure"></i></span>
                                <input type="text" class="form-control" id="route_from" name="route_from" placeholder="Kota asal" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="route_to" class="form-label">Ke</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-plane-arrival"></i></span>
                                <input type="text" class="form-control" id="route_to" name="route_to" placeholder="Kota tujuan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="depart_date" class="form-label">Tanggal Keberangkatan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" class="form-control" id="depart_date" name="depart_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="transport_type" class="form-label">Jenis Transportasi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-bus"></i></span>
                                <select class="form-select" id="transport_type" name="transport_type">
                                    <option value="">Semua Jenis Transportasi</option>
                                    @foreach($transportTypes as $type)
                                    <option value="{{ $type->id_type_trans }}">{{ $type->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Cari Tiket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features-section">
    <div class="container">
        <h2 class="text-center mb-5">Mengapa Memilih Travelasing?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="feature-icon rounded-circle mx-auto mb-4">
                            <i class="fas fa-tag fa-2x"></i>
                        </div>
                        <h4>Harga Terbaik</h4>
                        <p class="text-muted">Dapatkan tiket dengan harga terbaik untuk berbagai tujuan perjalanan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="feature-icon rounded-circle mx-auto mb-4">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h4>Pembayaran Aman</h4>
                        <p class="text-muted">Transaksi pembayaran aman dan terpercaya untuk ketenangan Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="feature-icon rounded-circle mx-auto mb-4">
                            <i class="fas fa-headset fa-2x"></i>
                        </div>
                        <h4>Dukungan 24/7</h4>
                        <p class="text-muted">Tim dukungan kami siap membantu Anda kapan saja diperlukan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular Destinations -->
<div class="destinations-section">
    <div class="container">
        <h2 class="text-center mb-5">Destinasi Populer</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card destination-card">
                    <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47" class="card-img-top" alt="Jakarta">
                    <div class="card-body">
                        <h5 class="card-title">Jakarta</h5>
                        <p class="card-text">Jelajahi ibu kota Indonesia dengan berbagai atraksi dan kuliner lezat.</p>
                        <a href="{{ route('search') }}?route_to=Jakarta" class="btn btn-sm btn-outline-primary">Temukan Tiket</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card destination-card">
                    <img src="https://images.unsplash.com/photo-1580861405977-9381fe4e597e" class="card-img-top" alt="Bali">
                    <div class="card-body">
                        <h5 class="card-title">Bali</h5>
                        <p class="card-text">Nikmati keindahan pulau dewata dengan pantai dan budaya yang menakjubkan.</p>
                        <a href="{{ route('search') }}?route_to=Bali" class="btn btn-sm btn-outline-primary">Temukan Tiket</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card destination-card">
                    <img src="https://images.unsplash.com/photo-1553855994-a53d4d6f783e" class="card-img-top" alt="Yogyakarta">
                    <div class="card-body">
                        <h5 class="card-title">Yogyakarta</h5>
                        <p class="card-text">Rasakan kekayaan sejarah dan budaya di kota pelajar yang istimewa.</p>
                        <a href="{{ route('search') }}?route_to=Yogyakarta" class="btn btn-sm btn-outline-primary">Temukan Tiket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials -->
<div class="testimonials-section">
    <div class="container">
        <h2 class="text-center mb-5">Apa Kata Pelanggan Kami</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="card shadow-sm">
                                <div class="card-body text-center p-5">
                                    <i class="fas fa-quote-left fa-3x text-muted mb-4"></i>
                                    <p class="lead">Layanan terbaik! Saya selalu menggunakan Travelasing untuk kebutuhan perjalanan saya. Proses pemesanan mudah dan harganya sangat bersaing.</p>
                                    <div class="d-flex justify-content-center mt-3">
                                        <div class="testimonial-avatar">
                                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="rounded-circle">
                                        </div>
                                        <div class="ms-3 text-start">
                                            <h5 class="mb-1">Budi Santoso</h5>
                                            <p class="mb-0 text-muted">Jakarta</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="card shadow-sm">
                                <div class="card-body text-center p-5">
                                    <i class="fas fa-quote-left fa-3x text-muted mb-4"></i>
                                    <p class="lead">Travelasing membuat perjalanan saya menjadi lebih mudah. Saya merekomendasikan layanan ini untuk semua yang ingin bepergian dengan nyaman!</p>
                                    <div class="d-flex justify-content-center mt-3">
                                        <div class="testimonial-avatar">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="rounded-circle">
                                        </div>
                                        <div class="ms-3 text-start">
                                            <h5 class="mb-1">Siti Rahma</h5>
                                            <p class="mb-0 text-muted">Surabaya</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="cta-section">
    <div class="container">
        <div class="card bg-primary text-white shadow">
            <div class="card-body p-5 text-center">
                <h3 class="mb-3">Siap untuk memulai perjalanan Anda?</h3>
                <p class="lead mb-4">Dapatkan pengalaman perjalanan terbaik dengan Travelasing sekarang juga</p>
                <a href="{{ route('search') }}" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-ticket-alt me-2"></i>Pesan Tiket Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom styles for home page */
    .hero-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }
    
    .search-section {
        margin-top: -3rem;
        margin-bottom: 5rem;
        z-index: 100;
        position: relative;
    }
    
    .features-section, .destinations-section, .testimonials-section {
        padding: 5rem 0;
    }
    
    .testimonials-section {
        background-color: #f8f9fa;
    }
    
    .cta-section {
        padding: 5rem 0;
    }
    
    .feature-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    
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
    
    .testimonial-avatar img {
        width: 60px;
        height: 60px;
    }
    
    .carousel-control-prev, .carousel-control-next {
        width: 40px;
        height: 40px;
        background-color: #0d6efd;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .carousel-control-prev {
        left: -20px;
    }
    
    .carousel-control-next {
        right: -20px;
    }
</style>
@endsection
