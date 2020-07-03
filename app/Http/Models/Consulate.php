<?php namespace App\Http\Models;

use App\Http\Models\Cats\CatConsulate;
use App\User;
use App\Http\Models\Operative;
use Illuminate\Database\Eloquent\Model;


use Carbon\Carbon;



class Consulate extends Model
{

    //protected $table = ['consulates'];
    protected $fillable = ['consulate_id','isActive'];
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

    // public function operatives()
    // {
    //     return $this->hasMany(Operative::class,'consulatee_id');
    // }


}
