<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Remainder');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
