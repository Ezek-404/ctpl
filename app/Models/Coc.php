<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coc extends Model
{
    // 1. Ilagay dito ang eksaktong pangalan ng table mo sa database
    protected $table = 'coc_table'; 

    protected $primaryKey = 'coc_id';

    protected $fillable = [
        'coc_id', 
        'coc_no', 
        'coc_type', 
        'coc_status',
    ];
}