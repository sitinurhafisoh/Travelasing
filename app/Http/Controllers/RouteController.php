<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Transport;
use App\Models\TransportType;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::with(['transport.transportType'])
            ->orderBy('depart', 'asc')
            ->paginate(10);
            
        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transports = Transport::all();
        return view('routes.create', compact('transports'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'depart' => 'required|date',
            'route_from' => 'required|string|max:255',
            'route_to' => 'required|string|max:255',
            'price' => 'required|numeric',
            'id_transport' => 'required|exists:transports,id_transport',
        ]);
        
        Route::create([
            'depart' => $request->depart,
            'route_from' => $request->route_from,
            'route_to' => $request->route_to,
            'price' => $request->price,
            'id_transport' => $request->id_transport,
        ]);
        
        return redirect()->route('routes.index')
            ->with('success', 'Rute berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        $route->load('transport.transportType');
        return view('routes.show', compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        // Only admin can edit routes
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $transports = Transport::all();
        return view('routes.edit', compact('route', 'transports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        // Only admin can update routes
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'depart' => 'required|date',
            'route_from' => 'required|string|max:255',
            'route_to' => 'required|string|max:255',
            'price' => 'required|numeric',
            'id_transport' => 'required|exists:transports,id_transport',
        ]);
        
        $route->update([
            'depart' => $request->depart,
            'route_from' => $request->route_from,
            'route_to' => $request->route_to,
            'price' => $request->price,
            'id_transport' => $request->id_transport,
        ]);
        
        return redirect()->route('routes.show', $route->id_route)
            ->with('success', 'Rute berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        // Only admin can delete routes
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if route has reservations
        if ($route->reservations()->count() > 0) {
            return redirect()->route('routes.index')
                ->with('error', 'Rute tidak dapat dihapus karena memiliki reservasi terkait.');
        }
        
        $route->delete();
        
        return redirect()->route('routes.index')
            ->with('success', 'Rute berhasil dihapus.');
    }

    /**
     * Show admin index of routes
     */
    public function adminIndex()
    {
        // Only admin can view admin routes page
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $routes = Route::with(['transport.transportType'])
            ->orderBy('depart', 'asc')
            ->paginate(20);
            
        return view('admin.routes.index', compact('routes'));
    }
}
