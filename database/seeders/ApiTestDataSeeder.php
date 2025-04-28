<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TransportType;
use App\Models\Transport;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApiTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user for API testing if not exists
        if (!User::where('username', 'apitest')->exists()) {
            User::create([
                'username' => 'apitest',
                'fullname' => 'API Test User',
                'email' => 'apitest@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        // Create admin user if not exists
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'username' => 'admin',
                'fullname' => 'Administrator',
                'email' => 'admin@travelasing.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]);
        }

        // Remove existing data to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schedule::truncate();
        Route::truncate();
        Transport::truncate();
        TransportType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Create Transport Types - Only Airplane
        $typeAirplane = TransportType::create([
            'description' => 'Pesawat',
        ]);

        // Create Transports (Airlines/Maskapai) - Only Airplanes
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

        $citilink = Transport::create([
            'code' => 'QG',
            'description' => 'Citilink',
            'seat' => 120,
            'id_transport_type' => $typeAirplane->id_transport_type,
        ]);

        $airAsia = Transport::create([
            'code' => 'QZ',
            'description' => 'Air Asia',
            'seat' => 150,
            'id_transport_type' => $typeAirplane->id_transport_type,
        ]);

        // Create Flight Routes
        $jakartaBali = Route::create([
            'depart' => '2025-05-01 08:00:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Bali',
            'price' => 1500000,
            'id_transport' => $garudaIndonesia->id_transport,
        ]);

        $jakartaSurabaya = Route::create([
            'depart' => '2025-05-02 09:00:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Surabaya',
            'price' => 1200000,
            'id_transport' => $lionAir->id_transport,
        ]);

        $baliJakarta = Route::create([
            'depart' => '2025-05-03 10:00:00',
            'route_from' => 'Bali',
            'route_to' => 'Jakarta',
            'price' => 1600000,
            'id_transport' => $garudaIndonesia->id_transport,
        ]);

        $surabayaJakarta = Route::create([
            'depart' => '2025-05-04 11:00:00',
            'route_from' => 'Surabaya',
            'route_to' => 'Jakarta',
            'price' => 1300000,
            'id_transport' => $lionAir->id_transport,
        ]);

        $jakartaMedan = Route::create([
            'depart' => '2025-05-05 07:30:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Medan',
            'price' => 1800000,
            'id_transport' => $citilink->id_transport,
        ]);

        $jakartaMakassar = Route::create([
            'depart' => '2025-05-06 08:15:00',
            'route_from' => 'Jakarta',
            'route_to' => 'Makassar',
            'price' => 1700000,
            'id_transport' => $airAsia->id_transport,
        ]);

        $makassarJakarta = Route::create([
            'depart' => '2025-05-07 16:30:00',
            'route_from' => 'Makassar',
            'route_to' => 'Jakarta',
            'price' => 1750000,
            'id_transport' => $airAsia->id_transport,
        ]);

        $medanJakarta = Route::create([
            'depart' => '2025-05-08 17:45:00',
            'route_from' => 'Medan',
            'route_to' => 'Jakarta',
            'price' => 1850000,
            'id_transport' => $citilink->id_transport,
        ]);

        // Create Flight Schedules
        Schedule::create([
            'id_route' => $jakartaBali->id_route,
            'depart_time' => '2025-05-01 08:00:00',
            'arrival_time' => '2025-05-01 10:00:00',
            'available_seats' => 180,
            'price' => 1500000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $jakartaBali->id_route,
            'depart_time' => '2025-05-01 12:00:00',
            'arrival_time' => '2025-05-01 14:00:00',
            'available_seats' => 180,
            'price' => 1600000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $jakartaBali->id_route,
            'depart_time' => '2025-05-01 16:00:00',
            'arrival_time' => '2025-05-01 18:00:00',
            'available_seats' => 180,
            'price' => 1700000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $baliJakarta->id_route,
            'depart_time' => '2025-05-01 09:00:00',
            'arrival_time' => '2025-05-01 11:00:00',
            'available_seats' => 180,
            'price' => 1600000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $baliJakarta->id_route,
            'depart_time' => '2025-05-01 13:00:00',
            'arrival_time' => '2025-05-01 15:00:00',
            'available_seats' => 180,
            'price' => 1700000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $jakartaSurabaya->id_route,
            'depart_time' => '2025-05-01 08:30:00',
            'arrival_time' => '2025-05-01 10:00:00',
            'available_seats' => 150,
            'price' => 1200000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $surabayaJakarta->id_route,
            'depart_time' => '2025-05-01 11:30:00',
            'arrival_time' => '2025-05-01 13:00:00',
            'available_seats' => 150,
            'price' => 1300000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $jakartaMedan->id_route,
            'depart_time' => '2025-05-02 07:30:00',
            'arrival_time' => '2025-05-02 10:30:00',
            'available_seats' => 120,
            'price' => 1800000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $medanJakarta->id_route,
            'depart_time' => '2025-05-02 17:45:00',
            'arrival_time' => '2025-05-02 20:45:00',
            'available_seats' => 120,
            'price' => 1850000,
            'status' => 'Delayed',
        ]);

        Schedule::create([
            'id_route' => $jakartaMakassar->id_route,
            'depart_time' => '2025-05-03 08:15:00',
            'arrival_time' => '2025-05-03 11:15:00',
            'available_seats' => 150,
            'price' => 1700000,
            'status' => 'Scheduled',
        ]);

        Schedule::create([
            'id_route' => $makassarJakarta->id_route,
            'depart_time' => '2025-05-03 16:30:00',
            'arrival_time' => '2025-05-03 19:30:00',
            'available_seats' => 150,
            'price' => 1750000,
            'status' => 'Cancelled',
        ]);
    }
}
