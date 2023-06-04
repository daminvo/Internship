<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class presence extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'entry_time','exit_time','observation','date','intern_id'
    ];
    public function intern()
    {
        return $this->belongsTo('App\intern');
    }
}
