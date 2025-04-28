<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use App\Models\TransportType;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RouteAPIController extends Controller
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
     * Display a listing of the routes.
     * Only return airplane routes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        $routes = Route::with(['transport', 'transport.transportType'])
            ->whereIn('id_transport', $airplaneTransportIds)
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Routes retrieved successfully',
            'data' => RouteResource::collection($routes)
        ]);
    }

    /**
     * Store a newly created route in storage.
     * Only allow creation of airplane routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'depart' => 'required|date',
            'route_from' => 'required|string|max:255',
            'route_to' => 'required|string|max:255',
            'price' => 'required|numeric',
            'id_transport' => 'required|exists:transports,id_transport',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify that transport is an airplane
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        if (!in_array($request->id_transport, $airplaneTransportIds)) {
            return response()->json([
                'success' => false,
                'message' => 'The specified transport must be an airplane'
            ], 400);
        }

        $route = Route::create($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Route created successfully',
            'data' => new RouteResource($route->load(['transport', 'transport.transportType']))
        ], 201);
    }

    /**
     * Display the specified route.
     * Only return if it's an airplane route.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        $route = Route::with(['transport', 'transport.transportType'])
            ->where('id_route', $id)
            ->whereIn('id_transport', $airplaneTransportIds)
            ->first();
        
        if (!$route) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found or not an airplane route'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Route retrieved successfully',
            'data' => new RouteResource($route)
        ]);
    }

    /**
     * Update the specified route in storage.
     * Only allow updates to airplane routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        $route = Route::whereIn('id_transport', $airplaneTransportIds)
            ->where('id_route', $id)
            ->first();
        
        if (!$route) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found or not an airplane route'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'depart' => 'sometimes|required|date',
            'route_from' => 'sometimes|required|string|max:255',
            'route_to' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'id_transport' => 'sometimes|required|exists:transports,id_transport',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // If transport is being updated, verify it's an airplane
        if ($request->has('id_transport') && !in_array($request->id_transport, $airplaneTransportIds)) {
            return response()->json([
                'success' => false,
                'message' => 'The specified transport must be an airplane'
            ], 400);
        }

        $route->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Route updated successfully',
            'data' => new RouteResource($route->fresh(['transport', 'transport.transportType']))
        ]);
    }

    /**
     * Remove the specified route from storage.
     * Only allow deletion of airplane routes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        $route = Route::whereIn('id_transport', $airplaneTransportIds)
            ->where('id_route', $id)
            ->first();
        
        if (!$route) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found or not an airplane route'
            ], 404);
        }
        
        $route->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Route deleted successfully'
        ]);
    }

    /**
     * Search routes by various criteria.
     * Only return airplane routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $airplaneTransportIds = $this->getAirplaneTransportIds();
        
        $query = Route::with(['transport', 'transport.transportType'])
            ->whereIn('id_transport', $airplaneTransportIds);
        
        if ($request->has('route_from')) {
            $query->where('route_from', 'like', '%' . $request->route_from . '%');
        }
        
        if ($request->has('route_to')) {
            $query->where('route_to', 'like', '%' . $request->route_to . '%');
        }
        
        if ($request->has('depart_date')) {
            $query->whereDate('depart', $request->depart_date);
        }
        
        if ($request->has('transport_id')) {
            // Verify it's an airplane transport
            if (!in_array($request->transport_id, $airplaneTransportIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The specified transport must be an airplane'
                ], 400);
            }
            $query->where('id_transport', $request->transport_id);
        }
        
        $routes = $query->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Routes searched successfully',
            'data' => RouteResource::collection($routes)
        ]);
    }
}
