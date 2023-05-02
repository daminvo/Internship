<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Users;

class Student extends Model
{
    public $timestamps = false;


    protected $fillable = [
        'user_id', 'student_card', 'cv', 'grade', 'security_number', 'birthday', 'birth_place', 'university_id', 'faculty_id', 'department_id', 'speciality', 'state'
    ];

    //public function offre(): HasOne
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

}
