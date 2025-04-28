@extends('layouts.app')

@section('title', 'Log API - Travelasing API')

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
                        <a href="{{ route('admin.schedules.index') }}" class="nav-link text-white">
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
                    <h1>Log Permintaan API</h1>
                    <a href="{{ route('admin.api-docs') }}" class="btn btn-outline-primary">
                        <i class="fas fa-file-code me-2"></i> Lihat Dokumentasi API
                    </a>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Permintaan API</h5>
                        <form action="{{ route('admin.api-logs') }}" method="GET" class="d-flex">
                            <select name="status" class="form-select me-2" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="200" {{ request('status') == '200' ? 'selected' : '' }}>200 (Sukses)</option>
                                <option value="400" {{ request('status') == '400' ? 'selected' : '' }}>400 (Bad Request)</option>
                                <option value="401" {{ request('status') == '401' ? 'selected' : '' }}>401 (Unauthorized)</option>
                                <option value="404" {{ request('status') == '404' ? 'selected' : '' }}>404 (Not Found)</option>
                                <option value="500" {{ request('status') == '500' ? 'selected' : '' }}>500 (Server Error)</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary">Filter</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Endpoint</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th>IP Address</th>
                                        <th>User Agent</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log['id'] }}</td>
                                        <td><code>{{ $log['endpoint'] }}</code></td>
                                        <td>
                                            @if($log['method'] == 'GET')
                                                <span class="badge bg-primary">GET</span>
                                            @elseif($log['method'] == 'POST')
                                                <span class="badge bg-success">POST</span>
                                            @elseif($log['method'] == 'PUT')
                                                <span class="badge bg-warning text-dark">PUT</span>
                                            @elseif($log['method'] == 'DELETE')
                                                <span class="badge bg-danger">DELETE</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $log['method'] }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($log['status'] >= 200 && $log['status'] < 300)
                                                <span class="badge bg-success">{{ $log['status'] }}</span>
                                            @elseif($log['status'] >= 400 && $log['status'] < 500)
                                                <span class="badge bg-warning text-dark">{{ $log['status'] }}</span>
                                            @elseif($log['status'] >= 500)
                                                <span class="badge bg-danger">{{ $log['status'] }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $log['status'] }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $log['ip'] }}</td>
                                        <td class="text-truncate" style="max-width: 200px;">{{ $log['user_agent'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($log['created_at'])->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i> Catatan: Log ini memperlihatkan permintaan API terbaru. Gunakan filter untuk melihat permintaan berdasarkan status.
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Statistik Permintaan API</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="requestsChart" width="100%" height="300"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Permintaan per Endpoint</h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                /api/transport-types
                                                <span class="badge bg-primary rounded-pill">25</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                /api/transports
                                                <span class="badge bg-primary rounded-pill">42</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                /api/routes
                                                <span class="badge bg-primary rounded-pill">38</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                /api/schedules
                                                <span class="badge bg-primary rounded-pill">31</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                /api/auth
                                                <span class="badge bg-primary rounded-pill">15</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample data for API requests chart
    const ctx = document.getElementById('requestsChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Permintaan API',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: '#3490dc',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
