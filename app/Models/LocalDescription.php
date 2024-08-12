<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalDescription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type() {

        return $this->belongsTo(LocalType::class, 'type_id','id');

    }

}
