<?php

namespace App\Http\Models\Cats;

use App\Http\Models\Formalities;
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

    public function formalities()
    {
        return $this->hasOne(
            Formalities::class,
            'subserie_id'
        );
    }

    public function descrip()
    {
        return $this->belongsToMany(CatDescription::class,
            'description_subseries',
            'cat_subserie_id',
            'cat_description_id');

    }

    public function sampli()
    {
        return $this->belongsToMany(CatDescription::class,
            'sampling_subseries',
            'cat_subserie_id',
            'cat_sampling_id');

    }

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('name', 'like', '%' .$search . '%')
                    ->orWhere ('code', 'like', '%' .$search . '%');
            });
        });
    }
}
