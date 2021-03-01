<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Cats\CatCity;
use App\Http\Models\Cats\CatPromotion;
use App\Http\Models\LevelsOfAttention;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'attention_id',
        'city_id',
        'promotion_id',
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

    public function attention()
    {
        return $this->belongsTo(LevelsOfAttention::class,'attention_id','id');
    }

}
