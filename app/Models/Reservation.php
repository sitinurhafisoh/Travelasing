<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Route;

class Reservation extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_reserv';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reserv_code',
        'reserv_at',
        'reserv_date',
        'seat',
        'depart',
        'price',
        'id_user',
        'id_route',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reserv_date' => 'date',
        'depart' => 'date',
        'price' => 'decimal:0',
    ];

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Get the route associated with the reservation.
     */
    public function route()
    {
        return $this->belongsTo(Route::class, 'id_route', 'id_route');
    }
}
