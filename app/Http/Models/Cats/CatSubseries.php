<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSubseries extends Model
{

    public function serie()
    {
        return $this->belongsTo(CatSeries::class, 'cat_series_id');
    }

    public function descrip()
    {
        return $this->belongsToMany(CatDescription::class,
            'description_subseries',
            'cat_subserie_id',
            'cat_description_id');

    }
}
