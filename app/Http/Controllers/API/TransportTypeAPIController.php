<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransportTypeResource;
use App\Models\TransportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransportTypeAPIController extends Controller
{
    /**
     * Display a listing of the transport types.
     * Only return airplane transport type.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get only Pesawat transport type
        $transportTypes = TransportType::where('description', 'Pesawat')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport types retrieved successfully',
            'data' => TransportTypeResource::collection($transportTypes)
        ]);
    }

    /**
     * Store a newly created transport type in storage.
     * Enforce that only airplane type can be created.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Force description to be 'Pesawat' regardless of input
        $data = $validator->validated();
        $data['description'] = 'Pesawat';
        
        $transportType = TransportType::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Transport type created successfully',
            'data' => new TransportTypeResource($transportType)
        ], 201);
    }

    /**
     * Display the specified transport type.
     * Only show if it's airplane type.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $transportType = TransportType::where('id_transport_type', $id)
            ->where('description', 'Pesawat')
            ->first();
        
        if (!$transportType) {
            return response()->json([
                'success' => false,
                'message' => 'Transport type not found or not an airplane type'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Transport type retrieved successfully',
            'data' => new TransportTypeResource($transportType)
        ]);
    }

    /**
     * Update the specified transport type in storage.
     * Only allow updates to airplane type and maintain it as airplane.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $transportType = TransportType::where('id_transport_type', $id)
            ->where('description', 'Pesawat')
            ->first();
        
        if (!$transportType) {
            return response()->json([
                'success' => false,
                'message' => 'Transport type not found or not an airplane type'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Force description to remain 'Pesawat'
        $transportType->description = 'Pesawat';
        $transportType->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport type updated successfully',
            'data' => new TransportTypeResource($transportType)
        ]);
    }

    /**
     * Remove the specified transport type from storage.
     * Only allow deletion of non-default airplane types.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $transportType = TransportType::where('id_transport_type', $id)
            ->where('description', 'Pesawat')
            ->first();
        
        if (!$transportType) {
            return response()->json([
                'success' => false,
                'message' => 'Transport type not found or not an airplane type'
            ], 404);
        }
        
        // Check if this is the default airplane type
        $count = TransportType::where('description', 'Pesawat')->count();
        if ($count <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete the default airplane transport type'
            ], 400);
        }
        
        $transportType->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport type deleted successfully'
        ]);
    }
}
