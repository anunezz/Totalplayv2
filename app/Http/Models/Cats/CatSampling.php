<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSampling extends Model
{
    protected $fillable = ['quality', 'cat_series_id'];

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function serie()
    {
        return $this->belongsTo(CatSeries::class, 'cat_series_id');
    }

    public function subserie()
    {
        return $this->belongsToMany(CatSampling::class,
            'sampling_subseries',
            'cat_sampling_id',
            'cat_subserie_id');
    }
}
