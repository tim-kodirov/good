<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function storehouses()
    {
        return $this->belongsToMany('App\Storehouse','remainders')->as('remainder')->withPivot('id','quantity')->withTimestamps();
    }

    public function requests()
    {
        return $this->hasManyThrough('App\Request','App\Remainder');
    }


}
