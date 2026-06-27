<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    // Tukuyin ang pangalan ng table kung hindi "vehicles" ang plural
    protected $table = 'vehicles';

    // Tukuyin ang primary key kung hindi "id"
    protected $primaryKey = 'vehicle_id';

    // Ilista ang mga columns na pwedeng i-mass assign
    protected $fillable = [
        'assured', 'address', 'year_model', 'make', 'series', 
        'denomination', 'color', 'plate_no', 'file_no', 
        'engine_no', 'chassis_no'
    ];

    // Disable timestamps kung wala kang created_at/updated_at sa table
    public $timestamps = false;
}