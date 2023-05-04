<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class internship extends Model
{
    /**
     * Get the offre associated with the internship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    //public function offre(): hasOne
    //{
      //  return $this->hasOne(InternshipOffre::class);
    ///}

    public function intern (): hasmany
    {
        return $this->hasMany('App\Intern');
    }

    public function students()
    {
        return $this->belongsToMany('App\Student', 'interns', 'internship_id', 'student_id');
    }


}
