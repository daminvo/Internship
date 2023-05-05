<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Intern extends Model
{
    // public function student()
    // {
    //     return $this->belongsTo("App\student");
    // }

    // public function internship()
    // {
    //     return $this->belongsToMany("App\internship");
    // }

    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function internship()
    {
        return $this->belongsTo('App\internship');
    }

    // public function internship()
    // {
    //     return $this->belongsTo(Internship::class);
    // }

}
