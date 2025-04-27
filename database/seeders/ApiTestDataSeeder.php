<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransportType;
use App\Models\Transport;
use App\Models\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user for API testing
        User::create([
            'username' => 'apitest',
            'fullname' => 'API Test User',
            'email' => 'apitest@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create Transport Types
        $typeAirplane = TransportType::create([
            'description' => 'Pesawat',
        ]);

        $typeTrain = TransportType::create([
            'description' => 'Kereta Api',
        ]);

        $typeBus = TransportType::create([
            'description' => 'Bus',
        ]);

        // Create Transports (Airlines/Maskapai)
        $garudaIndonesia = Transport::create([
            'code' => 'GA',
            'description' => 'Garuda Indonesia',
            'seat' => 180,
            'id_transport_type' => $typeAirplane->id_transport_type,
        ]);

        $lionAir = Transport::create([
            'code' => 'JT',
            'description' => 'Lion Air',
            'seat' => 150,
            'id_transport_type' => $typeAirplane->id_transport_type,
        ]);

        $airAsia = Transport::create([
            'code' => 'QZ',
            'description' => 'Air Asia',
            'seat' => 160,
            'id_transport_type' => $typeAirplane->id_transport_type,
        ]);

        $kaiEksekutif = Transport::create([
            'code' => 'KAI-1',
            'description' => 'Kereta Api Eksekutif',
            'seat' => 80,
            'id_transport_type' => $typeTrain->id_transport_type,
        ]);

        $kaiBisnis = Transport::create([
            'code' => 'KAI-2',
            'description' => 'Kereta Api Bisnis',
            'seat' => 100,
            'id_transport_type' => $typeTrain->id_transport_type,
        ]);

        $sinarJaya = Transport::create([
            'code' => 'SJ',
            'description' => 'Sinar Jaya',
            'seat' => 40,
            'id_transport_type' => $typeBus->id_transport_type,
        ]);

        // Create Routes (Flight Routes)
        // Airplane Routes
        Route::create([
            'depart' => '2025-05-01 08:00:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Bali',
            'price' => 1500000,
            'id_transport' => $garudaIndonesia->id_transport,
        ]);

        Route::create([
            'depart' => '2025-05-01 10:30:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Bali',
            'price' => 1200000,
            'id_transport' => $lionAir->id_transport,
        ]);

        Route::create([
            'depart' => '2025-05-01 14:15:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Surabaya',
            'price' => 900000,
            'id_transport' => $airAsia->id_transport,
        ]);

        Route::create([
            'depart' => '2025-05-02 09:45:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Medan',
            'price' => 1800000,
            'id_transport' => $garudaIndonesia->id_transport,
        ]);

        Route::create([
            'depart' => '2025-05-02 16:30:00',
            'route_from' => 'Surabaya',
            'route_to' => 'Jakarta',
            'price' => 950000,
            'id_transport' => $lionAir->id_transport,
        ]);

        // Train Routes
        Route::create([
            'depart' => '2025-05-01 07:00:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Bandung',
            'price' => 350000,
            'id_transport' => $kaiEksekutif->id_transport,
        ]);

        Route::create([
            'depart' => '2025-05-01 13:00:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Yogyakarta',
            'price' => 450000,
            'id_transport' => $kaiBisnis->id_transport,
        ]);

        // Bus Routes
        Route::create([
            'depart' => '2025-05-01 06:00:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Bandung',
            'price' => 120000,
            'id_transport' => $sinarJaya->id_transport,
        ]);

        Route::create([
            'depart' => '2025-05-01 20:00:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Semarang',
            'price' => 180000,
            'id_transport' => $sinarJaya->id_transport,
        ]);
    }
}
