<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternshipManager extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'company_id','validation'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo('App\company', 'company_id');
    }

    public function internship (): hasone
    {
        return $this->hasone('App\internship');
    }
}
