<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remainder extends Model
{
    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    public function exports()
    {
        return $this->hasMany('App\Export');
    }

    public function imports()
    {
        return $this->hasMany('App\Import');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function storehouse()
    {
        return $this->belongsTo('App\Storehouse');
    }

}
