<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationGap extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function subAspect() {

        return $this->belongsTo(SupAspect::class, 'sub_aspect_id','id');

    }

    public function gap() {

        return $this->belongsTo(Gap::class, 'gap_id','id');

    }
}
