<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromptAnswer extends Model
{
    protected $fillable = [ 'group_id', 'prompt_id', 'date', 'prompt', 'answer', 'url' ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
