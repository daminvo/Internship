<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentHeader extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'department_id', 'validation'
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function department()
    {
        return $this->belongsTo('App\department');

    }

}
