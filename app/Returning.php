<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returning extends Model
{
    public function export()
    {
        $this->belongsTo('App\Export');
    }
}
