<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatCodePromotion extends Model
{
    protected $fillable = [
        'name',
        'isActive'
    ];
}
