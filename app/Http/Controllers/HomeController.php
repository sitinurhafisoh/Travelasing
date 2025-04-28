<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\TransportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Mendapatkan tipe transportasi untuk pilihan di form pencarian
        $transportTypes = \App\Models\TransportType::all();
        
        // Mendapatkan rute populer
        $featuredRoutes = \App\Models\Route::with(['transport', 'transport.transportType'])
                          ->orderBy('id_route', 'desc')
                          ->take(5)
                          ->get();
        
        return view('home', compact('transportTypes', 'featuredRoutes'));
    }

    /**
     * Show the search page for routes.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function searchForm()
    {
        $transportTypes = TransportType::all();
        return view('search', compact('transportTypes'));
    }

    /**
     * Process the search request for routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $request->validate([
            'route_from' => 'required|string',
            'route_to' => 'required|string',
            'depart' => 'required|date',
        ]);

        $query = Route::query();

        // Apply filters
        if ($request->route_from) {
            $query->where('route_from', 'like', '%' . $request->route_from . '%');
        }

        if ($request->route_to) {
            $query->where('route_to', 'like', '%' . $request->route_to . '%');
        }

        if ($request->depart) {
            $query->whereDate('depart', '>=', $request->depart);
        }

        if ($request->transport_type) {
            $query->whereHas('transport', function ($q) use ($request) {
                $q->where('id_transport_type', $request->transport_type);
            });
        }

        $routes = $query->with(['transport.transportType'])->paginate(10);

        $transportTypes = TransportType::all();
        
        return view('search-results', compact('routes', 'transportTypes'));
    }

    /**
     * Show user dashboard page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = auth()->user();
        $reservations = $user->reservations()
            ->with(['route.transport'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('dashboard', compact('reservations'));
    }

    /**
     * Show admin dashboard page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminDashboard()
    {
        // Check if admin is logged in
        if (!Auth::check()) {
            return redirect('/admin/login');
        }
        
        // Data untuk dashboard
        $routes = \App\Models\Route::count();
        $transports = \App\Models\Transport::count();
        $schedules = \App\Models\Schedule::count();
        $apiRequestCount = 100; // Placeholder, should be replaced with actual API request count
        
        // Data untuk chart API requests (placeholder data)
        $apiRequestsData = [15, 25, 35, 45, 55, 40, 30];
        
        return view('admin.dashboard', compact('routes', 'transports', 'schedules', 'apiRequestCount', 'apiRequestsData'));
    }
}
