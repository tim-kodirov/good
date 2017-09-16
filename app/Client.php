<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function exports()
    {
        $this->hasMany('App\Export');
    }

    public function imports()
    {
        $this->hasMany('App\Import');
    }
}
