<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActuatorState extends Model
{
    protected $fillable = [
        'actuator_identity',
        'operating_state',
    ];
}
