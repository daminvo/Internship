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
      //  return $this->hasOne(InternshipOffer::class);
    ///}

    public function intern (): hasmany
    {
        return $this->hasMany('App\Intern');
    }

    public function students()
    {
        return $this->belongsToMany('App\Student', 'interns', 'internship_id', 'student_id');
    }

    public function manager()
    {
        return $this->belongsTo('App\InternshipManager', 'manager_id');
    }

}
