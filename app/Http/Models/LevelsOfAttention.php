<?php  namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Cats\CatAttention;

class LevelsOfAttention extends Model
{
    protected $fillable = ['user_id','attention_id','observations_contacted','observations_finish','isActive'];
    protected $with  = [];

    public function catAttention()
    {
        return $this->belongsTo(
            CatAttention::class,
            'attention_id'
        )->where( 'isActive', 1 );
    }

}
