<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Intern extends Model
{
    protected $fillable = [
        // other fillable fields
        'header_validation',
    ];
    public $timestamps = false;
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
