<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Cats\CatCity;
use App\Http\Models\Cats\CatPromotion;

class Contact extends Model
{
    protected $fillable = [
        'name',
        //'zip_code',
        'city_id',
        'promotion_id',
        //'email',
        'phone',
        'promotion_code'];

    public function city()
    {
        return $this->belongsTo(CatCity::class,'city_id','id');
    }
    public function pack()
    {
        return $this->belongsTo(CatPromotion::class,'promotion_id','id');
    }

}
