<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternshipManager extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'company_id','validation'
    ];

    protected $appends = ['companyName'];


    public function getCompanyNameAttribute()
    {
        return optional($this->company)->name;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo('App\company', 'company_id');
    }

    public function internship ()
    {
        return $this->hasone('App\internship');
    }
}
