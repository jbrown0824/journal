<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoreFeeling extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
}
