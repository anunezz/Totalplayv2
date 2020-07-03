<?php namespace App\Http\Models;

use App\Http\Models\Cats\CatConsulate;
use App\User;
use Illuminate\Database\Eloquent\Model;


class Strategy extends Model
{
    protected $fillable = ['period', 'cat_consulate_id', 'date', 'guns', 'civilSociety', 'democrats', 'republicans', 'academy',
        'economicActors', 'personalities', 'localAuthorities', 'media', 'articleLink', 'additional', 'observations'];
    protected $appends = ['hash'];


    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function getIsCreatorAttribute()
    {
        if(\Auth::check()){
            return $this->user_id === auth()->user()->id;
        }

    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function consulate()
    {
        return $this->belongsTo(
            CatConsulate::class,
            'cat_consulate_id'
        )->where( 'isActive', 1 );
    }
}
