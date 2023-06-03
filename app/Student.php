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

    protected $appends = ['departmentName', 'facultyName', 'universityName'];

    public function getDepartmentNameAttribute()
    {
        return optional($this->department)->name;
    }

    public function getFacultyNameAttribute()
    {
        return optional(optional($this->department)->faculty)->name;
    }

    public function getUniversityNameAttribute()
    {
        return optional(optional(optional($this->department)->faculty)->university)->name;
    }



    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function intern()
    {
        return $this->hasOne("App\intern");
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function internships()
    {
        return $this->belongsToMany('App\internship', 'Interns', 'student_id', 'internship_id');

    }





}
