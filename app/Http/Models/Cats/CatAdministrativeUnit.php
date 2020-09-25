<?php

namespace App\Http\Models\Cats;

use App\Http\Models\Formalities;
use Illuminate\Database\Eloquent\Model;

class CatAdministrativeUnit extends Model
{
    protected $fillable = ['name', 'specialName', 'determinant', 'cat_type_id'];

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function formalities()
    {
        return $this->hasOne(
            Formalities::class,
            'unit_id'
        );
    }

    public function sectionAll()
    {
        return $this->belongsToMany(
            CatSection::class,
            'admin_unit_section',
            'cat_administrative_unit_id',
            'cat_section_id'
        )->whereIsactive(true)->orderBy('name');
    }

    public function series()
    {
        return $this->belongsToMany(
            CatSeries::class,
            'series_units',
            'cat_administrative_unit_id',
            'cat_serie_id'
        )->whereIsactive(true)->orderBy('name');
    }

    public function descriptions()
    {
        return $this->belongsToMany(
            CatDescription::class,
            'description_units',
            'cat_unit_id',
            'cat_description_id'
        )->whereIsactive(true);
    }

//    public function responsible()
//    {
//        return $this->hasOne(CatAdministrativeUnit::class,
//            'users_units',
//            'cat_responsible_id'
//            );
//    }
//
//    public function user()
//    {
//        return $this->belongsToMany(CatAdministrativeUnit::class,
//            'users_units',
//            'cat_user_id',
//            'cat_administrative_unit_id');
//    }

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('name', 'like', '%' .$search . '%')
                    ->orWhere ('determinant', 'like', '%' .$search . '%');
            });
        });
    }

}
