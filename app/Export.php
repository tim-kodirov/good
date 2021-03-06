<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    public function remainder()
    {
        return $this->belongsTo('App\Remainder');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function returns()
    {
        return $this->hasMany('App\Returning');
    }
}
