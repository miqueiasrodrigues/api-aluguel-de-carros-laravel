<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'car_id',
        'start_date',
        'final_date',
        'date_realized',
        'daily_value',
        'initial_km',
        'initial_km',
    ];
}
