<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceImplemented extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id','id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id','id');
    }
}
