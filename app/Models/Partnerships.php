<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partnerships extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function type()
    {
        return $this->belongsTo(PartnershipsType::class, 'partnership_type'); 
    }

    public function status()
    {
        return $this->belongsTo(partnershipsStatus::class, 'partnership_status'); 
    }
    
}
