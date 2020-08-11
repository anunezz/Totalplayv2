<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSeries extends Model
{

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function primarivalues()
    {
        return $this->belongsToMany(CatPrimaryValues::class,
            'series_primary_values',
        'cat_serie_id',
        'cat_primary_value_id');
    }

    public function section()
    {
        return $this->belongsTo(CatSection::class, 'cat_section_id');
    }

    public function selection()
    {
        return $this->belongsTo(CatSelectionTechniques::class, 'cat_selection_id');
    }

    public function descriptions()
    {
        return $this->hasMany(CatDescription::class,
        'cat_series_id');
    }

}
