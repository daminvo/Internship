<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Intern extends Model
{
    protected $fillable = [
        'student_id', 'internship_id', 'start_date', 'end_date', 'motivation', 'valide'
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
