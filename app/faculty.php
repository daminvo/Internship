<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class faculty extends Model
{
    public function university()
    {
        return $this->belongsTo('App\university');
    }
}
