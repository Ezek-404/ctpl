<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CtplIssuance extends Model
{

    protected $table = 'ctpl_issuances';
    
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'transaction_id', 
        'policy_no', 
        'assured', 
        'address', 
        'agent', 
        'amount', 
        'coc_id', 
        'vehicle_id'
    ];

    protected $casts = [
        'transaction_id' => 'string',
    ];

    public function coc()
    {
        // Kung ang primary key ng Coc model ay 'coc_id'
        return $this->belongsTo(Coc::class, 'coc_id', 'coc_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }
}