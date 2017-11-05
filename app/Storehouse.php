<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Storehouse extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product','remainders')->as('remainder')->withPivot('id','quantity')->withTimestamps();
    }

    public function exports()
    {
        return $this->hasManyThrough('App\Export','App\Remainder');
    }

    public function imports()
    {
        return $this->hasManyThrough('App\Import','App\Remainder');
    }

    public function requests()
    {
        return $this->hasManyThrough('App\Request','App\Remainder');
    }

    public function owner()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
