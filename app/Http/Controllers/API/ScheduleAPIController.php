<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use App\Models\TransportType;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleAPIController extends Controller
{
    /**
     * Get airplane transport IDs.
     * 
     * @return array
     */
    private function getAirplaneTransportIds()
    {
        $airplaneTypeId = TransportType::where('description', 'Pesawat')->first()->id_transport_type;
        return Transport::where('id_transport_type', $airplaneTypeId)->pluck('id_transport')->toArray();
    }

    /**
     * Display a listing of all flight schedules.
     * Only return airplane flight schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        $schedules = Route::with(['transport', 'transport.transportType'])
            ->whereIn('id_transport', $airplaneTransportIds)
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
     * Only return if it's an airplane flight schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        $schedule = Route::with(['transport', 'transport.transportType'])
            ->where('id_route', $id)
            ->whereIn('id_transport', $airplaneTransportIds)
            ->first();
        
        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Flight schedule not found or not an airplane flight'
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
     * Only return airplane flight schedules.
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

        $airplaneTransportIds = $this->getAirplaneTransportIds();

        $schedules = Route::with(['transport', 'transport.transportType'])
            ->whereIn('id_transport', $airplaneTransportIds)
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
     * Only return airplane flight schedules.
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

        $airplaneTransportIds = $this->getAirplaneTransportIds();

        $query = Route::with(['transport', 'transport.transportType'])
            ->whereIn('id_transport', $airplaneTransportIds)
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
     * Only return airplane flight schedules.
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

        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        // Verify it's an airplane transport
        if (!in_array($request->id_transport, $airplaneTransportIds)) {
            return response()->json([
                'success' => false,
                'message' => 'The specified transport must be an airplane'
            ], 400);
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
