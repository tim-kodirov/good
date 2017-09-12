<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Remainder');
    }
}
