<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Remainder');
    }
}
