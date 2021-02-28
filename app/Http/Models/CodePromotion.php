<?php   namespace App\Http\Models;

use App\User;
use App\Http\Models\Cats\CatPromotion;
use Illuminate\Database\Eloquent\Model;

class CodePromotion extends Model
{
    protected $fillable = [
        'user_id',
        'promotion_id',
        'promotion_code',
        'isActive'
    ];
    protected $with = ['user','pack'];

    public function user()
    {
        return $this->hasOne(
            User::class,
            'id','user_id'
        );
    }

    public function pack()
    {
        return $this->hasOne(
            CatPromotion::class,
            'id','promotion_id'
        );
    }

}
