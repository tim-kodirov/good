<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function storehouses()
    {
        return $this->belongsToMany('App\Storehouse')->using('App\Remainder');
    }
}
