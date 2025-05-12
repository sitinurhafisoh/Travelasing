<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $reservations = $user->reservations()
            ->with(['route.transport'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $routeId = $request->route_id;
        $route = Route::with('transport')->findOrFail($routeId);
        
        // Generate a random 9-digit reservation code
        $digits = range(1, 9);
        shuffle($digits);
        $reservCode = implode('', array_slice($digits, 0, 9));
        
        return view('reservations.index', compact('route', 'reservCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reserv_code' => 'required|string|max:20',
            'reserv_at' => 'required|date',
            'reserv_date' => 'required|date',
            'seat' => 'required|string',
            'depart' => 'required|date',
            'price' => 'required|numeric',
            'id_route' => 'required|exists:routes,id_route',
        ]);
        
        $reservation = new Reservation();
        $reservation->reserv_code = $request->reserv_code;
        $reservation->reserv_at = $request->reserv_at;
        $reservation->reserv_date = $request->reserv_date;
        $reservation->seat = $request->seat;
        $reservation->depart = $request->depart;
        $reservation->price = $request->price;
        $reservation->id_user = Auth::id();
        $reservation->id_route = $request->id_route;
        $reservation->status = 'Proses';
        $reservation->description = $request->description ?? '';
        $reservation->save();
        
        return redirect()->route('reservations.show', $reservation->id_reserv)
            ->with('success', 'Reservasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        // Make sure the reservation belongs to the authenticated user
        if ($reservation->id_user != Auth::id() && !session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $reservation->load(['route.transport', 'user']);
        
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        // Only admin can edit reservations
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $reservation->load(['route.transport', 'user']);
        
        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Only admin can update reservations
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'status' => 'required|string|max:100',
            'description' => 'nullable|string|max:10',
        ]);
        
        $reservation->status = $request->status;
        $reservation->description = $request->description;
        $reservation->save();
        
        return redirect()->route('reservations.show', $reservation->id_reserv)
            ->with('success', 'Status reservasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // Only admin can delete reservations
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $reservation->delete();
        
        return redirect()->route('admin.reservations')
            ->with('success', 'Reservasi berhasil dihapus.');
    }
    
    /**
     * Print the ticket
     */
    public function print(Reservation $reservation)
    {
        // Make sure the reservation belongs to the authenticated user
        if ($reservation->id_user != Auth::id() && !session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $reservation->load(['route.transport', 'user']);
        
        return view('reservations.print', compact('reservation'));
    }
    
    /**
     * Show all reservations (admin only)
     */
    public function adminIndex()
    {
        // Only admin can view all reservations
        if (!session('admin_id')) {
            abort(403, 'Unauthorized action.');
        }
        
        $reservations = Reservation::with(['route.transport', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.reservations.index', compact('reservations'));
    }
}
