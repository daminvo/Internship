<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternshipManager extends Model
{
    public $timestamps = false;
    protected $fillable = ['company_id', 'user_id'];
}
