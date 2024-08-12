<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesSlide extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function slide() {

        return $this->belongsTo(Slide::class, 'slide_id', 'id');
    }

}
