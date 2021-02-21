<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatPromotion extends Model
{
    public function scopeFilter($query, $data)
    {
        return $query->where(function($q) use ($data){

            if($data['type'] === 1){
                if ( is_bool($data['typePack']) === true ){
                    $q->where("triple_double",$data['typePack']);
                }
            }

            $q->where("frontier",$data['city'])->where('type',$data['type'])->where('isActive',1);
        });
    }


}
