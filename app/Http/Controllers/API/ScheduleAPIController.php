<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleAPIController extends Controller
{
    /**
     * Display a listing of all flight schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schedules = Route::with(['transport', 'transport.transportType'])
            ->orderBy('depart')
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Flight schedules retrieved successfully',
            'data' => RouteResource::collection($schedules)
        ]);
    }

    /**
     * Display the specified flight schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $schedule = Route::with(['transport', 'transport.transportType'])->find($id);
        
        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Flight schedule not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Flight schedule retrieved successfully',
            'data' => new RouteResource($schedule)
        ]);
    }

    /**
     * Search flight schedules by date range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $schedules = Route::with(['transport', 'transport.transportType'])
            ->whereBetween('depart', [$request->start_date, $request->end_date])
            ->orderBy('depart')
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Flight schedules searched successfully',
            'data' => RouteResource::collection($schedules)
        ]);
    }

    /**
     * Search flight schedules by origin and destination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByRoute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_from' => 'required|string',
            'route_to' => 'required|string',
            'date' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Route::with(['transport', 'transport.transportType'])
            ->where('route_from', 'like', '%' . $request->route_from . '%')
            ->where('route_to', 'like', '%' . $request->route_to . '%');
            
        if ($request->has('date')) {
            $query->whereDate('depart', $request->date);
        }
        
        $schedules = $query->orderBy('depart')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Flight schedules searched successfully',
            'data' => RouteResource::collection($schedules)
        ]);
    }

    /**
     * Search flight schedules by airline (maskapai).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByAirline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_transport' => 'required|exists:transports,id_transport',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $schedules = Route::with(['transport', 'transport.transportType'])
            ->where('id_transport', $request->id_transport)
            ->orderBy('depart')
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Flight schedules searched successfully',
            'data' => RouteResource::collection($schedules)
        ]);
    }
}
