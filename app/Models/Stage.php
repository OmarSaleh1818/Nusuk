<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function businesses()
    {
        return $this->hasMany(Business::class, 'stage_id', 'id');
    }

}
