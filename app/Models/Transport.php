<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransportType;
use App\Models\Route;

class Transport extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_transport';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'description',
        'seat',
        'id_transport_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'seat' => 'integer',
    ];

    /**
     * Get the transport type associated with this transport.
     */
    public function transportType()
    {
        return $this->belongsTo(TransportType::class, 'id_transport_type', 'id_transport_type');
    }

    /**
     * Get the routes associated with this transport.
     */
    public function routes()
    {
        return $this->hasMany(Route::class, 'id_transport', 'id_transport');
    }
}
