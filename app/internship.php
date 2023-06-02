<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class internship extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'duration', 'title', 'description', 'state', 'gender', 'demand_date', 'manager_id'
    ];

    /**
     * Get the offre associated with the internship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    //public function offre(): hasOne
    //{
      //  return $this->hasOne(InternshipOffer::class);
    ///}

    public function intern ()
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

    public function internshipOffer ()
    {
        return $this->hasone('App\internshipOffer');
    }

}
