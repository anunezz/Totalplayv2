<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Cats\CatCity;

class CatState extends Model
{
    public function city()
    {
        return $this->hasMany(CatCity::class,'state_id','id');
        //return $this->belongsToMany(CatCity::class);
    }

}
