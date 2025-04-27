<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transport;
use App\Models\Reservation;

class Route extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_route';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'depart',
        'route_from',
        'route_to',
        'price',
        'id_transport',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'depart' => 'date',
        'price' => 'decimal:0',
    ];

    /**
     * Get the transport associated with this route.
     */
    public function transport()
    {
        return $this->belongsTo(Transport::class, 'id_transport', 'id_transport');
    }

    /**
     * Get the reservations for this route.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_route', 'id_route');
    }
}
