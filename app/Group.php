<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $fillable = [ 'owner_id', 'name' ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'group_users');
    }

    public function prompts() {
        return $this->hasMany(Prompt::class);
    }

    public function scopeCanJoin($query) {
        return $query->where('can_join', true);
    }
}
