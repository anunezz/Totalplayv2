<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSubseries extends Model
{
    protected $appends = ['full_name', 'hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function getFullNameAttribute()
    {
        return $this->code . '-' . $this->name;
    }

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
