<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'work_ability','discipline','initiative','capacity_imagination','acquired_knowledge','total_note','appreciation','intern_id'
    ];

    public function intern()
    {
        return $this->belongsTo('App\intern');
    }
}
