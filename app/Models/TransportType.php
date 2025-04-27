<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transport;

class TransportType extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_transport_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
    ];

    /**
     * Get the transports for this transport type.
     */
    public function transports()
    {
        return $this->hasMany(Transport::class, 'id_transport_type', 'id_transport_type');
    }
}
