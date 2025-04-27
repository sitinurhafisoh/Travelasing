<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransportResource;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransportAPIController extends Controller
{
    /**
     * Display a listing of the transports.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $transports = Transport::with('transportType')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Transports retrieved successfully',
            'data' => TransportResource::collection($transports)
        ]);
    }

    /**
     * Store a newly created transport in storage.
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
            'id_transport_type' => 'required|exists:transport_types,id_transport_type',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $transport = Transport::create($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Transport created successfully',
            'data' => new TransportResource($transport->load('transportType'))
        ], 201);
    }

    /**
     * Display the specified transport.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $transport = Transport::with('transportType')->find($id);
        
        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Transport not found'
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $transport = Transport::find($id);
        
        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Transport not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|required|string|max:50',
            'description' => 'sometimes|required|string|max:255',
            'seat' => 'sometimes|required|integer',
            'id_transport_type' => 'sometimes|required|exists:transport_types,id_transport_type',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $transport->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Transport updated successfully',
            'data' => new TransportResource($transport->fresh('transportType'))
        ]);
    }

    /**
     * Remove the specified transport from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $transport = Transport::find($id);
        
        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Transport not found'
            ], 404);
        }
        
        $transport->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport deleted successfully'
        ]);
    }
}
