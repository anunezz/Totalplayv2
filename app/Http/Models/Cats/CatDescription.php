<?php namespace App\Http\Models\Cats;

use App\Http\Models\Formalities;
use Illuminate\Database\Eloquent\Model;

class CatDescription extends Model
{
    protected $fillable = ['description', 'cat_series_id'];

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function formalities()
    {
        return $this->hasOne(
            Formalities::class,
            'description_id'
        );
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

    public function subserie()
    {
        return $this->belongsToMany(CatAdministrativeUnit::class,
            'description_subseries',
            'cat_description_id',
            'cat_subserie_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('description', 'like', '%' .$search . '%');
            });
        });
    }
}
