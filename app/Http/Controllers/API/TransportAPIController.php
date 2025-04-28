<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransportResource;
use App\Models\Transport;
use App\Models\TransportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransportAPIController extends Controller
{
    /**
     * Display a listing of the transports.
     * Only return airplane transports.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get the airplane transport type ID
        $airplaneTypeId = TransportType::where('description', 'Pesawat')->first()->id_transport_type;
        
        // Get only transports with the airplane type
        $transports = Transport::with('transportType')
            ->where('id_transport_type', $airplaneTypeId)
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Transports retrieved successfully',
            'data' => TransportResource::collection($transports)
        ]);
    }

    /**
     * Store a newly created transport in storage.
     * Only allow creation of airplane transports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'seat' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get the airplane transport type ID
        $airplaneType = TransportType::where('description', 'Pesawat')->first();
        
        if (!$airplaneType) {
            return response()->json([
                'success' => false,
                'message' => 'Airplane transport type not found'
            ], 404);
        }
        
        // Create transport with airplane type
        $transport = new Transport($validator->validated());
        $transport->id_transport_type = $airplaneType->id_transport_type;
        $transport->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport created successfully',
            'data' => new TransportResource($transport->load('transportType'))
        ], 201);
    }

    /**
     * Display the specified transport.
     * Only return if it's an airplane transport.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Get the airplane transport type ID
        $airplaneTypeId = TransportType::where('description', 'Pesawat')->first()->id_transport_type;
        
        $transport = Transport::with('transportType')
            ->where('id_transport', $id)
            ->where('id_transport_type', $airplaneTypeId)
            ->first();
        
        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Transport not found or not an airplane'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Transport retrieved successfully',
            'data' => new TransportResource($transport)
        ]);
    }

    /**
     * Update the specified transport in storage.
     * Only allow updates to airplane transports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Get the airplane transport type ID
        $airplaneTypeId = TransportType::where('description', 'Pesawat')->first()->id_transport_type;
        
        $transport = Transport::where('id_transport', $id)
            ->where('id_transport_type', $airplaneTypeId)
            ->first();
        
        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Transport not found or not an airplane'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|required|string|max:50',
            'description' => 'sometimes|required|string|max:255',
            'seat' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update while maintaining airplane type
        $transport->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Transport updated successfully',
            'data' => new TransportResource($transport->fresh('transportType'))
        ]);
    }

    /**
     * Remove the specified transport from storage.
     * Only allow deletion of airplane transports.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Get the airplane transport type ID
        $airplaneTypeId = TransportType::where('description', 'Pesawat')->first()->id_transport_type;
        
        $transport = Transport::where('id_transport', $id)
            ->where('id_transport_type', $airplaneTypeId)
            ->first();
        
        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Transport not found or not an airplane'
            ], 404);
        }
        
        $transport->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport deleted successfully'
        ]);
    }
}
