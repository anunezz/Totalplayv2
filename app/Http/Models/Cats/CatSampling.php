<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSampling extends Model
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
}
