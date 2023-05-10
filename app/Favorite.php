<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    protected $guarded = [];
    protected $casts = [

            'student_id' => 'integer',
            'offer_id' => 'integer',

    ];
    // protected $hidden = ['id', '']

    public function student () {
        return $this->belongsTo('App\Student');
    }

    public function offer () {
        return $this->belongsTo('App\InternshipOffer');
    }
}
