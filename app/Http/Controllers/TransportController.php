<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\TransportType;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transports = Transport::with('transportType')
            ->orderBy('description')
            ->paginate(10);
            
        return view('transports.index', compact('transports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only admin can create transports
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $transportTypes = TransportType::all();
        return view('admin.transports.create', compact('transportTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admin can store transports
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'code' => 'required|string|max:10|unique:transports,code',
            'description' => 'required|string|max:255',
            'seat' => 'required|integer',
            'id_transport_type' => 'required|exists:transport_types,id_transport_type',
        ]);
        
        Transport::create([
            'code' => $request->code,
            'description' => $request->description,
            'seat' => $request->seat,
            'id_transport_type' => $request->id_transport_type,
        ]);
        
        return redirect()->route('admin.transports.index')
            ->with('success', 'Transportasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transport $transport)
    {
        $transport->load('transportType');
        return view('transports.show', compact('transport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transport $transport)
    {
        // Only admin can edit transports
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $transportTypes = TransportType::all();
        return view('admin.transports.edit', compact('transport', 'transportTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transport $transport)
    {
        // Only admin can update transports
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'code' => 'required|string|max:10|unique:transports,code,' . $transport->id_transport . ',id_transport',
            'description' => 'required|string|max:255',
            'seat' => 'required|integer',
            'id_transport_type' => 'required|exists:transport_types,id_transport_type',
        ]);
        
        $transport->update([
            'code' => $request->code,
            'description' => $request->description,
            'seat' => $request->seat,
            'id_transport_type' => $request->id_transport_type,
        ]);
        
        return redirect()->route('admin.transports.show', $transport->id_transport)
            ->with('success', 'Transportasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transport $transport)
    {
        // Only admin can delete transports
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if transport is used in any routes
        if ($transport->routes()->count() > 0) {
            return redirect()->route('admin.transports.index')
                ->with('error', 'Transportasi tidak dapat dihapus karena digunakan dalam rute.');
        }
        
        $transport->delete();
        
        return redirect()->route('admin.transports.index')
            ->with('success', 'Transportasi berhasil dihapus.');
    }
    
    /**
     * Display admin listing of transports
     */
    public function adminIndex()
    {
        $transports = Transport::with('transportType')
            ->orderBy('description')
            ->paginate(10);
            
        return view('admin.transports.index', compact('transports'));
    }
    
    /**
     * Transport types management
     */
    public function typeIndex()
    {
        $types = TransportType::orderBy('description')->paginate(10);
        return view('admin.transport-types.index', compact('types'));
    }
    
    public function typeCreate()
    {
        return view('admin.transport-types.create');
    }
    
    public function typeStore(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);
        
        TransportType::create([
            'description' => $request->description,
        ]);
        
        return redirect()->route('admin.transport-types.index')
            ->with('success', 'Tipe transportasi berhasil ditambahkan.');
    }
    
    public function typeEdit(TransportType $type)
    {
        return view('admin.transport-types.edit', compact('type'));
    }
    
    public function typeUpdate(Request $request, TransportType $type)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);
        
        $type->update([
            'description' => $request->description,
        ]);
        
        return redirect()->route('admin.transport-types.index')
            ->with('success', 'Tipe transportasi berhasil diperbarui.');
    }
    
    public function typeDestroy(TransportType $type)
    {
        // Check if type is used in any transports
        if ($type->transports()->count() > 0) {
            return redirect()->route('admin.transport-types.index')
                ->with('error', 'Tipe transportasi tidak dapat dihapus karena digunakan dalam transportasi.');
        }
        
        $type->delete();
        
        return redirect()->route('admin.transport-types.index')
            ->with('success', 'Tipe transportasi berhasil dihapus.');
    }
}
