<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_route',
        'depart_time',
        'arrival_time',
        'available_seats',
        'price',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'depart_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'float',
    ];

    /**
     * Get the route that owns the schedule.
     */
    public function route()
    {
        return $this->belongsTo(Route::class, 'id_route', 'id_route');
    }
}
