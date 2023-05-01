<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class internship extends Model
{
    /**
     * Get the offre associated with the internship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function offre(): HasOne
    {
        return $this->hasOne(InternshipOffre::class);
    }
}
