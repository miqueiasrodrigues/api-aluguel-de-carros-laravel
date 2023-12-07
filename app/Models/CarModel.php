<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand_id', 
        'name', 
        'image', 
        'num_door', 
        'num_places',
        'air_bag',
        'abs',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
