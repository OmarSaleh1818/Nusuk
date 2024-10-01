<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationAspect extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Area() {

        return $this->belongsTo(EvaluationArea::class);

    }

}
