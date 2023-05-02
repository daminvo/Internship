<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternshipManager extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'company_id'
    ];
}
