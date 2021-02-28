<?php namespace App\Http\Models\Cats;
use App\Http\Models\Cats\CatNamePaks;
use App\Http\Models\FilePromotionModal;
use App\Http\Models\ImgPromotion;
use Illuminate\Database\Eloquent\Model;

class CatPromotion extends Model
{
    protected $fillable = ['type','frontier','triple_double','name','color','description','isActive'];
    protected $with = ['namepack','imgpromotion','imgpromotionmodal'];

    public function namepack()
    {
        return $this->belongsTo(
            CatNamePaks::class,
            'type','id'
            //'type','id'
        );
    }

    public function imgpromotion()
    {
        return $this->hasOne(
            ImgPromotion::class,
            'promotion_id','id'
        );
    }

    public function imgpromotionmodal()
    {
        return $this->hasOne(
            FilePromotionModal::class,
            'promotion_id','id'
        );
    }

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
