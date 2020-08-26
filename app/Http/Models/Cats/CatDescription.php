<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatDescription extends Model
{
    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function serie()
    {
        return $this->belongsTo(CatSeries::class, 'cat_series_id');
    }

    public function administrative()
    {
        return $this->belongsToMany(CatAdministrativeUnit::class,
            'description_units',
            'cat_description_id',
            'cat_unit_id');
    }
}
