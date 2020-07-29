<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSubseries extends Model
{
    public function serie()
    {
        return $this->belongsTo(CatSeries::class, 'cat_series_id');
    }
}
