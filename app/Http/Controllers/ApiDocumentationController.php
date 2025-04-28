<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocumentationController extends Controller
{
    /**
     * Display the API documentation page.
     */
    public function index()
    {
        return view('admin.api.documentation');
    }

    /**
     * Display the API logs page.
     */
    public function logs()
    {
        // Placeholder for API logs - in a real implementation, we might fetch from a logs table
        $logs = [
            [
                'id' => 1,
                'endpoint' => '/api/transport-types',
                'method' => 'GET',
                'status' => 200,
                'ip' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'created_at' => now()->subHours(1),
            ],
            [
                'id' => 2,
                'endpoint' => '/api/transports',
                'method' => 'GET',
                'status' => 200,
                'ip' => '192.168.1.2',
                'user_agent' => 'PostmanRuntime/7.28.4',
                'created_at' => now()->subHours(2),
            ],
            [
                'id' => 3,
                'endpoint' => '/api/routes/search',
                'method' => 'GET',
                'status' => 200,
                'ip' => '192.168.1.3',
                'user_agent' => 'PostmanRuntime/7.28.4',
                'created_at' => now()->subHours(3),
            ],
            [
                'id' => 4,
                'endpoint' => '/api/auth/login',
                'method' => 'POST',
                'status' => 200,
                'ip' => '192.168.1.4',
                'user_agent' => 'PostmanRuntime/7.28.4',
                'created_at' => now()->subHours(5),
            ],
        ];

        return view('admin.api.logs', compact('logs'));
    }
}
