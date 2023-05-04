<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentHeader extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'department_id', 'validation'
    ];
}
