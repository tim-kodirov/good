<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Remainder extends Pivot
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

}
