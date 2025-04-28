@extends('layouts.app')

@section('title', 'Tambah Maskapai Baru')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Admin -->
        <div class="col-md-2 bg-dark text-white" style="min-height: calc(100vh - 100px);">
            <div class="d-flex flex-column p-3">
                <h4 class="text-center my-3">Panel Admin</h4>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.transport-types.index') }}" class="nav-link text-white {{ request()->routeIs('admin.transport-types.*') ? 'active' : '' }}">
                            Tipe Transportasi
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.transports.index') }}" class="nav-link text-white {{ request()->routeIs('admin.transports.*') ? 'active' : '' }}">
                            Maskapai
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.routes.index') }}" class="nav-link text-white {{ request()->routeIs('admin.routes.*') ? 'active' : '' }}">
                            Rute Penerbangan
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.schedules.index') }}" class="nav-link text-white {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                            Jadwal Penerbangan
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.api-docs') }}" class="nav-link text-white {{ request()->routeIs('admin.api-docs') ? 'active' : '' }}">
                            Dokumentasi API
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.api-logs') }}" class="nav-link text-white {{ request()->routeIs('admin.api-logs') ? 'active' : '' }}">
                            Log API
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-10">
            <div class="p-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Maskapai Baru</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.transports.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label for="code">Kode Maskapai</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                                @error('code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Masukkan kode maskapai (contoh: GA, JT, dll.)</small>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="description">Nama Maskapai</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" required>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="seat">Jumlah Kursi</label>
                                <input type="number" class="form-control @error('seat') is-invalid @enderror" id="seat" name="seat" value="{{ old('seat') }}" required>
                                @error('seat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="id_transport_type">Tipe Transportasi</label>
                                <select class="form-control @error('id_transport_type') is-invalid @enderror" id="id_transport_type" name="id_transport_type" required>
                                    <option value="">-- Pilih Tipe Transportasi --</option>
                                    @foreach($transportTypes as $type)
                                        <option value="{{ $type->id_transport_type }}" {{ old('id_transport_type') == $type->id_transport_type ? 'selected' : '' }}>
                                            {{ $type->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_transport_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.transports.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
