<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Internship;

class InternshipOffer extends Model
{
    /**
     * Get the user that owns the InternshipOffer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function internship()
    {
        return $this->belongsTo('App\internship');
    }

    public function is_favorited () {
        return $this->hasOne('App\Favorite', 'offer_id');
    }

}
