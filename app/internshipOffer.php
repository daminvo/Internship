<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Internship;

class internshipOffer extends Model
{
    /**
     * Get the user that owns the internshipOffer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }


}
