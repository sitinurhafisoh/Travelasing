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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $transportTypes = TransportType::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport types retrieved successfully',
            'data' => TransportTypeResource::collection($transportTypes)
        ]);
    }

    /**
     * Store a newly created transport type in storage.
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

        $transportType = TransportType::create($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Transport type created successfully',
            'data' => new TransportTypeResource($transportType)
        ], 201);
    }

    /**
     * Display the specified transport type.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $transportType = TransportType::find($id);
        
        if (!$transportType) {
            return response()->json([
                'success' => false,
                'message' => 'Transport type not found'
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $transportType = TransportType::find($id);
        
        if (!$transportType) {
            return response()->json([
                'success' => false,
                'message' => 'Transport type not found'
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

        $transportType->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Transport type updated successfully',
            'data' => new TransportTypeResource($transportType)
        ]);
    }

    /**
     * Remove the specified transport type from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $transportType = TransportType::find($id);
        
        if (!$transportType) {
            return response()->json([
                'success' => false,
                'message' => 'Transport type not found'
            ], 404);
        }
        
        $transportType->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Transport type deleted successfully'
        ]);
    }
}
