<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Student extends Model
{
    public $timestamps = false;


    protected $fillable = [
        'user_id', 'student_card', 'cv', 'grade', 'security_number', 'birthday', 'birth_place', 'university_id', 'faculty_id', 'department_id', 'speciality', 'state'
    ];

    //public function offre(): HasOne
    public function user()
    {
        return $this->belongsTo('App\user', 'student_id');
    }

}
