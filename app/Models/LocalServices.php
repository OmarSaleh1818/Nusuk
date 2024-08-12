<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalServices extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function target()
    {
        return $this->belongsTo(LocalTarget::class, 'target_id', 'id');
    }
}
