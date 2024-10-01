<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationEvaluation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function opportunity() {

        return $this->belongsTo(OpportunityData::class, 'opportunityData_id','id');

    }

    public function aspect()
    {
        return $this->belongsTo(EvaluationAspect::class, 'evaluation_aspect_id','id');
    }

    public function choice()
    {
        return $this->belongsTo(EvaluationChoices::class, 'evaluation_choice_id','id');
    }

}
