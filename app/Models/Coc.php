<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coc extends Model
{
    // 1. Ilagay dito ang eksaktong pangalan ng table mo sa database
    protected $table = 'coc_table'; 

    // 2. Ilagay dito ang mga column na pwedeng i-mass assign
    // Siguraduhin na kasama lahat ng columns na ginagamit mo sa iyong table
    protected $fillable = [
        'coc_id', 
        'coc_no', 
        'coc_type', 
        'coc_status',
        // Dagdagan mo pa kung may iba ka pang columns
    ];
}