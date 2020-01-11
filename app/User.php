<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'consecutive_days', 'last_journaled_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_journaled_at' => 'date',
    ];

    public function groups() {
        return $this->belongsToMany(Group::class, 'group_users');
    }

    public function core_feelings() {
        return $this->hasMany(CoreFeeling::class);
    }

    public function prompt_answers() {
        return $this->hasMany(PromptAnswer::class);
    }
}
