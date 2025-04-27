<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RouteAPIController extends Controller
{
    /**
     * Display a listing of the routes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $routes = Route::with(['transport', 'transport.transportType'])->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Routes retrieved successfully',
            'data' => RouteResource::collection($routes)
        ]);
    }

    /**
     * Store a newly created route in storage.
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

        $route = Route::create($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Route created successfully',
            'data' => new RouteResource($route->load(['transport', 'transport.transportType']))
        ], 201);
    }

    /**
     * Display the specified route.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $route = Route::with(['transport', 'transport.transportType'])->find($id);
        
        if (!$route) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found'
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $route = Route::find($id);
        
        if (!$route) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found'
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

        $route->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Route updated successfully',
            'data' => new RouteResource($route->fresh(['transport', 'transport.transportType']))
        ]);
    }

    /**
     * Remove the specified route from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $route = Route::find($id);
        
        if (!$route) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found'
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = Route::with(['transport', 'transport.transportType']);
        
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
            $query->where('id_transport', $request->transport_id);
        }
        
        if ($request->has('transport_type_id')) {
            $query->whereHas('transport', function($q) use ($request) {
                $q->where('id_transport_type', $request->transport_type_id);
            });
        }
        
        $routes = $query->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Routes searched successfully',
            'data' => RouteResource::collection($routes)
        ]);
    }
}
