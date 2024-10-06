<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function opportunity() {

        return $this->belongsTo(Opportunity::class, 'opportunity_id','id');

    }

    public function status() {

        return $this->belongsTo(OpportunityStatus::class, 'status_id','id');

    }

}
