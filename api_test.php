<?php

/**
 * Simple API Testing Script for Travelasing REST API
 * 
 * Cara menggunakan script ini:
 * 1. Jalankan php artisan serve di terminal
 * 2. Buka file ini di browser: http://localhost/Travelasing/api_test.php
 */

// Base URL untuk API
$baseUrl = 'http://localhost:8000/api';

// Fungsi untuk melakukan request ke API
function makeRequest($url, $method = 'GET', $data = null, $token = null) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $headers = ['Accept: application/json', 'Content-Type: application/json'];
    
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'response' => json_decode($response, true)
    ];
}

// Fungsi untuk menampilkan hasil test
function displayResult($title, $result) {
    echo "<div style='margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;'>";
    echo "<h3>{$title}</h3>";
    echo "<p>Status Code: {$result['code']}</p>";
    
    echo "<pre>";
    print_r($result['response']);
    echo "</pre>";
    
    echo "</div>";
}

// Mulai output HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travelasing API Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .test-section {
            margin-bottom: 40px;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Travelasing API Test</h1>
    
    <div class="test-section">
        <h2>1. Public Endpoints Test</h2>
        
        <?php
        // Test mendapatkan semua tipe transport
        $result = makeRequest($baseUrl . '/transport-types');
        displayResult('GET /transport-types', $result);
        
        // Test mendapatkan semua transport/maskapai
        $result = makeRequest($baseUrl . '/transports');
        displayResult('GET /transports', $result);
        
        // Test mendapatkan semua rute
        $result = makeRequest($baseUrl . '/routes');
        displayResult('GET /routes', $result);
        
        // Test mendapatkan semua jadwal
        $result = makeRequest($baseUrl . '/schedules');
        displayResult('GET /schedules', $result);
        
        // Test pencarian rute
        $searchData = [
            'route_from' => 'Jakarta',
            'route_to' => 'Bali'
        ];
        $result = makeRequest($baseUrl . '/routes/search', 'POST', $searchData);
        displayResult('POST /routes/search', $result);
        
        // Test pencarian jadwal berdasarkan tanggal
        $dateSearchData = [
            'start_date' => '2025-05-01',
            'end_date' => '2025-05-02'
        ];
        $result = makeRequest($baseUrl . '/schedules/search/date', 'POST', $dateSearchData);
        displayResult('POST /schedules/search/date', $result);
        ?>
    </div>
    
    <div class="test-section">
        <h2>2. Authentication Test</h2>
        
        <?php
        // Test login
        $loginData = [
            'email' => 'apitest@example.com',
            'password' => 'password'
        ];
        $loginResult = makeRequest($baseUrl . '/auth/login', 'POST', $loginData);
        displayResult('POST /auth/login', $loginResult);
        
        // Dapatkan token jika login berhasil
        $token = null;
        if ($loginResult['code'] === 200 && isset($loginResult['response']['data']['access_token'])) {
            $token = $loginResult['response']['data']['access_token'];
            
            // Test get user info with token
            $userResult = makeRequest($baseUrl . '/auth/user', 'GET', null, $token);
            displayResult('GET /auth/user (dengan token)', $userResult);
            
            // Test membuat tipe transport baru (protected endpoint)
            $newTypeData = [
                'description' => 'Kapal Laut'
            ];
            $createResult = makeRequest($baseUrl . '/transport-types', 'POST', $newTypeData, $token);
            displayResult('POST /transport-types (dengan token)', $createResult);
            
            // Test logout
            $logoutResult = makeRequest($baseUrl . '/auth/logout', 'POST', null, $token);
            displayResult('POST /auth/logout', $logoutResult);
        } else {
            echo "<p style='color: red;'>Login gagal, tidak dapat menguji endpoint yang terproteksi!</p>";
        }
        ?>
    </div>
    
    <div class="test-section">
        <h2>3. Cross-Origin Test</h2>
        <p>Berikut adalah contoh JavaScript untuk melakukan permintaan API dari aplikasi lain:</p>
        
        <pre>
fetch('<?php echo $baseUrl; ?>/transport-types', {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
        </pre>
        
        <p>Untuk request yang memerlukan otentikasi:</p>
        
        <pre>
// Pertama, login untuk mendapatkan token:
fetch('<?php echo $baseUrl; ?>/auth/login', {
    method: 'POST',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        email: 'apitest@example.com',
        password: 'password'
    })
})
.then(response => response.json())
.then(data => {
    const token = data.data.access_token;
    
    // Kemudian gunakan token untuk request protected endpoints:
    fetch('<?php echo $baseUrl; ?>/auth/user', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => response.json())
    .then(userData => console.log(userData))
    .catch(error => console.error('Error:', error));
})
.catch(error => console.error('Error:', error));
        </pre>
        
        <p>Contoh registrasi user baru:</p>
        
        <pre>
fetch('<?php echo $baseUrl; ?>/auth/register', {
    method: 'POST',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        username: 'newuser',
        fullname: 'New User',
        email: 'newuser@example.com',
        password: 'password',
        password_confirmation: 'password'
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
        </pre>
    </div>
</body>
</html>
