<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'addresse'];
}
