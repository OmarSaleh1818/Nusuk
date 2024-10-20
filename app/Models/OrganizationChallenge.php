<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationChallenge extends Model
{
    use HasFactory;

    protected $guarded = [];
    

    public function user() {

        return $this->belongsTo(User::class, 'user_id','id');

    }

    public function institutionalChallenge() {

        return $this->belongsTo(SupAspect::class, 'institutional_challenge_id','id');

    }

    public function challenge() {

        return $this->belongsTo(Challenge::class, 'challenge_id','id');

    }

}
