<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationPrivateIndicator extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function opportunityData() {

        return $this->belongsTo(OpportunityData::class, 'opportunityData_id','id');

    }

    public function privateIndicator() {

        return $this->belongsTo(PrivateIndicator::class, 'private_indicator_id','id');

    }
    
}
