<?php  namespace App\Http\Models\Cats;

use App\Http\Models\Cats\CatState;
use Illuminate\Database\Eloquent\Model;

class CatCity extends Model
{
    public function state()
    {
        //return $this->hasMany(CatCity::class,'state_id','id');
        return $this->belongsTo(CatState::class);
    }
}
