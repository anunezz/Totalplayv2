<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatAdministrativeUnit extends Model
{
    protected $fillable = ['name', 'cat'];

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
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

//    public function sections()
//    {
//        return $this->belongsToMany(
//            CatSection::class,
//            'admin_unit_section',
//            'cat_administrative_unit_id',
//            'cat_section_id'
//        )->whereIsactive(true)->orderBy('name');
//    }

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('name', 'like', '%' .$search . '%');
            });
        });
    }

}
