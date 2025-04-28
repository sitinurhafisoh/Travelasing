<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     */
    public function index()
    {
        $schedules = Schedule::with(['route', 'route.transport'])
            ->orderBy('depart_time', 'desc')
            ->paginate(10);
        
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create(Request $request)
    {
        $routes = Route::with('transport')->get();
        $selectedRouteId = $request->route_id;
        
        return view('admin.schedules.create', compact('routes', 'selectedRouteId'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|exists:routes,id_route',
            'depart_time' => 'required|date',
            'arrival_time' => 'required|date|after:depart_time',
            'available_seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Scheduled,Delayed,Cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $schedule = new Schedule();
        $schedule->id_route = $request->route_id;
        $schedule->depart_time = $request->depart_time;
        $schedule->arrival_time = $request->arrival_time;
        $schedule->available_seats = $request->available_seats;
        $schedule->price = $request->price;
        $schedule->status = $request->status;
        $schedule->save();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal penerbangan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(Schedule $schedule)
    {
        $routes = Route::with('transport')->get();
        return view('admin.schedules.edit', compact('schedule', 'routes'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|exists:routes,id_route',
            'depart_time' => 'required|date',
            'arrival_time' => 'required|date|after:depart_time',
            'available_seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Scheduled,Delayed,Cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $schedule->id_route = $request->route_id;
        $schedule->depart_time = $request->depart_time;
        $schedule->arrival_time = $request->arrival_time;
        $schedule->available_seats = $request->available_seats;
        $schedule->price = $request->price;
        $schedule->status = $request->status;
        $schedule->save();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal penerbangan berhasil diperbarui');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal penerbangan berhasil dihapus');
    }
}
