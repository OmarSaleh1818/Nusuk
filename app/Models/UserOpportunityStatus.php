<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOpportunityStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function opportunityData() {

        return $this->belongsTo(OpportunityData::class, 'opportunity_id','id');

    }

    public function status() {

        return $this->belongsTo(SharingStatus::class, 'status','id');

    }

}
