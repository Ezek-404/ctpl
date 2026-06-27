<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CtplIssuance extends Model
{
    // Tukuyin ang table name kung hindi ito ang default (default: ctpl_issuances)
    protected $table = 'ctpl_issuances';
    
    // Tukuyin ang primary key
    protected $primaryKey = 'transaction_id';

    // Payagan ang mass assignment para sa mga fields
    protected $fillable = [
        'policy_no', 'assured', 'address', 'agent', 'amount', 'coc_id', 'vehicle_id'
    ];

    // Relationship pabalik sa Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }
}