<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Users;

class Student extends Model
{
    //public function offre(): HasOne
   // public function student(): BelongsTo
    //{
      //  return $this->belongsTo(User::class, 'student_id');
    //}

    public function intern()
    {
        return $this->hasOne("App\intern");
    }

    public function internships()
    {
        return $this->belongsToMany('App\internship', 'Interns', 'student_id', 'internship_id');

    }




}
