<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    public function faculty()
    {
        return $this->belongsTo('App\faculty', 'faculty_id');
    }
}
