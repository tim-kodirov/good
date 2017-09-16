<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    public function remainder()
    {
        return $this->belongsTo('App\Remainder');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
