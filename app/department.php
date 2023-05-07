<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    public function departmentHeader()
    {
        return $this->hasOne('App\departmentHeader');

    }

    public function student()
    {
        return $this->hasMany('App\student');

    }
}
